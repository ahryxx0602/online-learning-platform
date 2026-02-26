<?php

namespace Modules\Lessons\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Lessons\App\Http\Requests\LessonsRequest;
use Modules\Courses\Repositories\CoursesRepositoryInterface;
use Modules\Lessons\Repositories\LessonsRepositoryInterface;
use Modules\Videos\Models\Video;
use Modules\Documents\Models\Document;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Modules\Documents\Repositories\DocumentsRepositoryInterface;
use Modules\Videos\Repositories\VideosRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class LessonsController extends Controller
{
    protected $lessonsRepository;
    protected $coursesRepository;
    protected $videosRepository;
    protected $documentsRepository;
    public function __construct(
        LessonsRepositoryInterface $lessonsRepository,
        CoursesRepositoryInterface $coursesRepository,
        VideosRepositoryInterface $videosRepository,
        DocumentsRepositoryInterface $documentsRepository
    ) {
        $this->lessonsRepository = $lessonsRepository;
        $this->coursesRepository = $coursesRepository;
        $this->videosRepository = $videosRepository;
        $this->documentsRepository = $documentsRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index($courseId)
    {
        $course = $this->coursesRepository->getCourse($courseId);
        if (!$course) {
            abort(404, 'Khóa học không tồn tại');
        }

        $pageTitle = 'Bài giảng: ' . $course->name;
        return view('lessons::list', compact('courseId', 'pageTitle', 'course'));
    }

    /**
     * Get data for DataTables
     */
    public function data(Request $request, $courseId)
    {
        // Lấy lessons theo phân cấp (parent trước, rồi đến con)
        $parentLessons = $this->lessonsRepository->getLessonsByHierarchy($courseId);

        $parentLessons->load('subLessons');

        // Chuyển thành danh sách phẳng với indentation
        $flatLessons = $this->getLessonsTable($parentLessons);

        // Trả về dữ liệu dạng DataTable
        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => count($flatLessons),
            'recordsFiltered' => count($flatLessons),
            'data' => $flatLessons,
        ]);
    }

    /**
     * Chuyển đổi danh sách bài giảng thành cấu trúc phân cấp
     */
    public function getLessonsTable($lessons, $char = '', &$result = []) {
        if (!empty($lessons)) {
            foreach ($lessons as $lesson) {
                // Chuyển object thành array để xử lý cho DataTable
                $row = is_object($lesson) ? $lesson->toArray() : $lesson;
                
                // Lưu lại danh sách con trước khi unset để đệ quy
                // Laravel toArray() sẽ chuyển subLessons thành sub_lessons
                $children = $row['sub_lessons'] ?? ($row['children'] ?? []);
    
                $row['select'] = '<input type="checkbox" class="row-check" value="' . $row['id'] . '">';
                $row['name'] = $char . $row['name'];
    
                if ($row['parent_id'] == null) {
                    $row['is_trial'] = '';
                    $row['views'] = '';
                    $row['duration'] = '';
                    $addUrl = route('admin.lessons.create', ['courseId' => $row['course_id']]) . '?module=' . $row['id'];
                    $row['add'] = '<a href="' . $addUrl . '" class="btn btn-info btn-sm"> <i class="fa fa-plus"></i> Thêm bài </a>';
                    $row['edit'] = '<a href="' . route('admin.lessons.edit', $row['id']) . '" class="btn btn-warning btn-sm"> <i class="fa fa-edit"></i> Sửa </a>';
                } else {
                    $row['is_trial'] = ($row['is_trial'] ?? 0) == 1 ? '<span class="badge badge-success">Có</span>' : '<span class="badge badge-secondary">Không</span>';
                    $row['views'] = $row['views'] ?? 0;
                    $row['duration'] = getTime($row['duration']);
                    
                    $row['add'] = ''; // Bài con không có nút "Thêm bài"
                    $row['edit'] = '<a href="' . route('admin.lessons.edit', $row['id']) . '" class="btn btn-warning btn-sm"> <i class="fa fa-edit"></i> Sửa </a>';
                    $deleteUrl = route('admin.lessons.delete', $row['id']);
                    $row['delete'] = '<button type="button" class="btn btn-danger delete-action btn-sm" data-url="' . $deleteUrl . '"> <i class="fa fa-trash"></i> Xóa </button>';
                }
    
                // Xóa dữ liệu thừa để nhẹ JSON trả về
                unset($row['sub_lessons'], $row['children'], $row['video'], $row['document'], $row['updated_at'], $row['created_at']);
                
                $result[] = $row;
    
                // Đệ quy nếu có bài học con
                if (!empty($children)) {
                    // Sử dụng ký tự phân cấp rõ ràng hơn
                    $this->getLessonsTable($children, $char . '│&nbsp;&nbsp;&nbsp;├─ ', $result);
                }
            }
        }
        return $result;
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $courseId)
    {
        $pageTitle = 'Thêm bài giảng';
        $position = $this->lessonsRepository->getPosition($courseId);
        $lessons = $this->lessonsRepository->getAllLessons($courseId);
        return view('lessons::add', compact('pageTitle', 'courseId', 'position', 'lessons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonsRequest $request, $courseId)
    {
        //Video
        $name = $request->name;
        $slug = $request->slug;
        $document = $request->document;
        $video = $request->video;
        $parent_id = $request->parent_id == 0 ? null : $request->parent_id;
        $is_trial = $request->is_trial;
        $position = $request->position;
        $description = $request->description;
        $documentId = null;
        $videoId = null;
        if ($document) {
            $documentInfo = getFileInfo($document);
            $document = $this->documentsRepository->createDocument([
                'url' => $document,
                'name' => $documentInfo['name'],
                'size' => $documentInfo['size']
            ], $document);
            $documentId = $document ? $document->id : null;
        }
        if ($video) {
            $videoInfo = getVideoInfo($video);
            $video = $this->videosRepository->createVideo(
                [
                    'url' => $video,
                    'name' => $videoInfo['filename'],
                    'size' => $videoInfo['duration']
                ],
                $video
            );
            $videoId = $video ? $video->id : null;
        }

        $this->lessonsRepository->create([
            'name' => $name,
            'slug' => $slug,
            'document_id' => $documentId,
            'video_id' => $videoId,
            'course_id' => $courseId,
            'parent_id' => $parent_id,
            'is_trial' => $is_trial,
            'position' => $position,
            'description' => $description,
            'duration' => $videoInfo['duration'] ?? 0,
        ]);
        $this->updateDurations($courseId);
        return redirect()->route('admin.lessons.create', ['courseId' => $courseId])->with('msg', __('lessons::message.create.success'));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('lessons::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $lessonId)
    {
        $pageTitle = 'Cập nhật bài giảng';
        $lesson = $this->lessonsRepository->find($lessonId);
        $lessons = $this->lessonsRepository->getAllLessons($lesson->course_id);
        $courseId = $lesson->course_id;
        $lesson->load(['video', 'document']);
        if (!$lesson) {
            abort(404, 'Bài giảng không tồn tại');
        }

        return view('lessons::edit', compact('lesson', 'pageTitle', 'lessons', 'courseId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LessonsRequest $request, $lessonId)
    {
        $lesson = $this->lessonsRepository->find($lessonId);
        $courseId = $lesson->course_id;
        $name = $request->name;
        $slug = $request->slug;
        $document = $request->document;
        $video = $request->video;
        $parent_id = $request->parent_id == 0 ? null : $request->parent_id;
        $is_trial = $request->is_trial;
        $position = $request->position;
        $description = $request->description;
        $documentId = null;
        $videoId = null;
        if ($document) {
            $documentInfo = getFileInfo($document);
            $document = $this->documentsRepository->createDocument([
                'url' => $document,
                'name' => $documentInfo['name'],
                'size' => $documentInfo['size']
            ], $document);
            $documentId = $document ? $document->id : null;
        }
        if ($video) {
            $videoInfo = getVideoInfo($video);
            $video = $this->videosRepository->createVideo(
                [
                    'url' => $video,
                    'name' => $videoInfo['filename'],
                    'size' => $videoInfo['duration']
                ],
                $video
            );
            $videoId = $video ? $video->id : null;
        }

        $this->lessonsRepository->update($lessonId,[
            'name' => $name,
            'slug' => $slug,
            'document_id' => $documentId,
            'video_id' => $videoId,
            'parent_id' => $parent_id,
            'is_trial' => $is_trial,
            'position' => $position,
            'description' => $description,
            'duration' => isset($videoInfo['playtime_seconds']) ? $videoInfo['playtime_seconds'] : $lesson->duration,
        ]);
        $this->updateDurations($courseId);
        return redirect()->route('admin.lessons.edit', ['lessonId' => $lessonId])->with('msg', __('lessons::message.update.success'));
    }
        

    /**
     * Remove the specified resource from storage.
     */
    public function delete($lessonId)
    {
        $lesson = $this->lessonsRepository->find($lessonId);
        $courseId = $lesson->course_id;
        $this->lessonsRepository->delete($lessonId);
        $this->updateDurations($courseId);
        return back()->with('msg', __('lessons::message.delete.success'));
    }

    /**
     * Delete multiple items.
     */
    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            return response()->json([
                'message' => 'Vui lòng chọn ít nhất 1 bài giảng',
            ], 422);
        }
        // Lấy course_id từ bài giảng đầu tiên trong danh sách ids
        // Vì bài toán của bạn là tất cả lesson đều nằm trong 1 course
        $firstLesson = $this->lessonsRepository->find($ids[0]);
        
        if (!$firstLesson) {
            return response()->json(['message' => 'Không tìm thấy dữ liệu'], 404);
        }

        $courseId = $firstLesson->course_id;

        // Thực hiện xóa hàng loạt
        $deleted = $this->lessonsRepository->deleteMultiple($ids);

        if ($deleted) {
            // Cập nhật lại tổng thời lượng cho khóa học này
            $this->updateDurations($courseId);
        }

        return response()->json([
            'message' => __('lessons::message.delete.success'),
            'deleted' => $deleted,
        ]);
    }
    public function sort(Request $request, $courseId){
        $pageTitle = 'Sắp xếp bài giảng';
        $modules = $this->lessonsRepository->getLessons($courseId)->with('children')->get();
        return view('lessons::sort', compact('pageTitle', 'courseId', 'modules'));
    }
    public function handleSort(Request $request, $courseId){
        $lessons = $request->lesson;
        if($lessons) {
            foreach($lessons as $index => $lessonId) {
                $this->lessonsRepository->update($lessonId, [
                    'position' => $index
                ]);
            }
        }
        return redirect()->route('admin.lessons.sort', $courseId)->with('msg', __('lessons::message.update.success'));
    }

    private function updateDurations($courseId){
        // Lấy all bài học trong 1 khóa
        $lessons = $this->lessonsRepository->getAllLessons($courseId);

        //Tính tổng thời lượng trong 1 khóa
        $totalDuration = $lessons->reduce(function($prev, $item){
            return $prev + $item->duration;
        }, 0);
        $this->coursesRepository->updateCourse($courseId, [
            'durations' => $totalDuration
        ]);
        
    }
}

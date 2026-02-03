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
        $course = $this->coursesRepository->find($courseId);
        
        if (!$course) {
            abort(404, 'Khóa học không tồn tại');
        }
        
        $pageTitle = 'Bài giảng: ' . $course->name;
        return view('lessons::list', compact('courseId', 'pageTitle', 'course'));
    }

    /**
     * Get data for DataTables
     */
    public function data(Request $request)
    {
        $courseId = $request->get('course_id'); 
        
        $lessons = $this->lessonsRepository->getAllLessons($courseId);
        
        return DataTables::of($lessons)
            ->addColumn('select', function ($lesson) {
                return '<input type="checkbox" class="row-check" value="' . $lesson->id . '">';
            })
            ->addColumn('edit', function ($lesson) {
                // Route 'admin.lessons.edit' chỉ cần {lessonId}, không cần courseId
                return '<a href="' . route("admin.lessons.edit", $lesson->id) . '" class="btn btn-warning btn-sm">
                    <i class="fa fa-edit"></i> Sửa
                </a>';
            })
            ->addColumn('delete', function ($lesson) {
                $deleteUrl = route("admin.lessons.delete", $lesson->id);
                return '<button type="button" class="btn btn-danger delete-action btn-sm" data-url="' . $deleteUrl . '">
                    <i class="fa fa-trash"></i> Xóa
                </button>';
            })
            ->editColumn('is_trial', function ($lesson) {
                return $lesson->is_trial; // Để JS tự render badge như bạn đã viết
            })
            ->editColumn('created_at', function ($lesson) {
                return $lesson->created_at?->format('Y-m-d H:i:s');
            })
            ->rawColumns(['select', 'edit', 'delete'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $courseId)
    {
        $pageTitle = 'Thêm bài giảng';
        $position = $this->lessonsRepository->getPosition($courseId);
        return view('lessons::add', compact('pageTitle', 'courseId','position'));
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
        if($document) {
            $documentInfo = getFileInfo($document);
            $document = $this->documentsRepository->createDocument([
                'url' => $document,
                'name' => $documentInfo['fileName'],
                'size' => $documentInfo['size']
            ], $document);
            $documentId = $document ? $document->id : null;
        }
        if($video ){
            $videoInfo = getVideoInfo($video);
            $video = $this->videosRepository->createVideo([
                'url' => $video, 
                'name' => $videoInfo['fileName'], 
                'size' => $videoInfo['playtime_seconds']], 
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
            'duration' => $videoInfo['playtime_seconds'] ?? 0,
        ]);
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
    public function edit($id)
    {
        $lesson = $this->lessonsRepository->find($id);
        
        if (!$lesson) {
            abort(404, 'Bài giảng không tồn tại');
        }
        
        // Load relationships để lấy URL video và document
        $lesson->load(['video', 'document']);
        
        $pageTitle = 'Cập nhật bài giảng';

        return view('lessons::edit', compact('lesson', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LessonsRequest $request, $id)
    {
        $lesson = $this->lessonsRepository->find($id);
        
        if (!$lesson) {
            abort(404, 'Bài giảng không tồn tại');
        }
        
        $data = $request->validated();
        
        // Xử lý is_trial
        $data['is_trial'] = $request->input('is_trial', 0) == 1;
        
        // Set giá trị mặc định
        $data['views'] = $data['views'] ?? $lesson->views ?? 0;
        $data['parent_id'] = $data['parent_id'] ?? null;
        
        // Xử lý video URL
        if (!empty($data['video'])) {
            // Nếu đã có video_id, update video hiện tại
            if ($lesson->video_id) {
                $video = Video::find($lesson->video_id);
                if ($video) {
                    $video->update(['url' => $data['video']]);
                    $data['video_id'] = $video->id;
                } else {
                    // Tạo mới nếu không tìm thấy
                    $video = Video::create([
                        'name' => $data['name'] . ' - Video',
                        'url' => $data['video'],
                    ]);
                    $data['video_id'] = $video->id;
                }
            } else {
                // Tạo mới video
                $video = Video::create([
                    'name' => $data['name'] . ' - Video',
                    'url' => $data['video'],
                ]);
                $data['video_id'] = $video->id;
            }
        }
        unset($data['video']);
        
        // Xử lý document URL
        if (!empty($data['document'])) {
            // Nếu đã có document_id, update document hiện tại
            if ($lesson->document_id) {
                $document = Document::find($lesson->document_id);
                if ($document) {
                    $document->update(['url' => $data['document']]);
                    $data['document_id'] = $document->id;
                } else {
                    // Tạo mới nếu không tìm thấy
                    $document = Document::create([
                        'name' => $data['name'] . ' - Document',
                        'url' => $data['document'],
                    ]);
                    $data['document_id'] = $document->id;
                }
            } else {
                // Tạo mới document
                $document = Document::create([
                    'name' => $data['name'] . ' - Document',
                    'url' => $data['document'],
                ]);
                $data['document_id'] = $document->id;
            }
        }
        unset($data['document']);
        
        // Giữ nguyên course_id nếu không được cung cấp
        if (!isset($data['course_id'])) {
            $data['course_id'] = $lesson->course_id;
        }

        $this->lessonsRepository->update($id, $data);

        return redirect()
            ->route('admin.lessons.index', ['courseId' => $lesson->course_id])
            ->with('msg', __('lessons::message.update.success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $this->lessonsRepository->delete($id);
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

        $deleted = $this->lessonsRepository->deleteMultiple($ids);

        return response()->json([
            'message' => __('lessons::message.delete.success'),
            'deleted' => $deleted,
        ]);
    }
}

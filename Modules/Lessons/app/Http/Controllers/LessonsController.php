<?php

namespace Modules\Lessons\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Lessons\App\Http\Requests\LessonsRequest;
use Modules\Courses\Repositories\CoursesRepositoryInterface;
use Modules\Lessons\Repositories\LessonsRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class LessonsController extends Controller
{
    protected $lessonsRepository;
    protected $coursesRepository;

    public function __construct(
        LessonsRepositoryInterface $lessonsRepository,
        CoursesRepositoryInterface $coursesRepository
    ) {
        $this->lessonsRepository = $lessonsRepository;
        $this->coursesRepository = $coursesRepository;
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
            ->editColumn('created_at', function ($lesson) {
                return $lesson->created_at?->format('Y-m-d H:i:s');
            })
            ->rawColumns(['select', 'edit', 'delete'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Thêm bài giảng';
        return view('lessons::add', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonsRequest $request)
    {
        $data = $request->validated();
        $data['is_trial'] = $request->boolean('is_trial');
        $data['views'] = $data['views'] ?? 0;

        $lesson = $this->lessonsRepository->create($data);

        return redirect()
            ->route('admin.lessons.index', ['courseId' => $lesson->course_id ?? ''])
            ->with('msg', __('lessons::message.create.success'));
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
        $pageTitle = 'Cập nhật bài giảng';

        return view('lessons::edit', compact('lesson', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
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

<?php

namespace Modules\Courses\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Categories\Repositories\CategoriesRepositoryInterface;
use Modules\Courses\App\Http\Requests\CoursesRequest;
use Modules\Courses\Repositories\CoursesRepositoryInterface;
use Modules\Teachers\Repositories\TeachersRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;

class CoursesController extends Controller
{
    protected $coursesRepository;
    protected $categoriesRepository;

    protected $teachersRepository;

    public function __construct(
        CoursesRepositoryInterface $coursesRepository,
        CategoriesRepositoryInterface $categoriesRepository,
        TeachersRepositoryInterface $teachersRepository
    )
    {
        $this->coursesRepository = $coursesRepository;
        $this->categoriesRepository = $categoriesRepository;
        $this->teachersRepository = $teachersRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Danh sách khóa học';
        return view('courses::list', compact('pageTitle'));
    }

    public function data()
    {
        $courses = $this->coursesRepository->getAllCourses();
        return DataTables::of($courses)
            ->addColumn('lessons', function ($course) {
                return '<a href="' . route("admin.lessons.index", $course->id) . '" class="btn btn-primary btn-sm">
                <i class="fa fa-list"></i> Bài giảng
            </a>';
            })
            ->addColumn('select', function ($course) {
                return '<input type="checkbox" class="row-check" value="' . $course->id . '">';
            })
            ->addColumn('edit', function ($course) {
                return '<a href="' . route("admin.courses.edit", $course->id) . '" class="btn btn-warning btn-sm">
                <i class="fa fa-edit"></i> Sửa
            </a>';
            })
            ->addColumn('delete', function ($course) {
                $deleteUrl = route("admin.courses.delete", $course->id);
                return
                    '<button type="button" class="btn btn-danger delete-action btn-sm" data-url="' . $deleteUrl . '">
                        <i class="fa fa-trash"></i> Xóa
                    </button>';
            })
            // Edit Column created_at
            ->editColumn('created_at', function ($course) {
                return $course->created_at?->format('Y-m-d H:i:s');
            })
            ->rawColumns(['select', 'edit', 'delete', 'lessons'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $pageTitle = 'Thêm khóa học';
        $categories = $this->categoriesRepository->getAllCategories();
        $teachers = $this->teachersRepository->getAllTeachers();
        return view('courses::add', compact('pageTitle', 'categories', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CoursesRequest $request)
    {
        $data  = $request->except('_token');
        if (!$data['sale_price']) {
            $data['sale_price'] = 0;
        }
        if (!$data['price']) {
            $data['price'] = 0;
        }
        $course = $this->coursesRepository->create($data);
        $categories = $this->getCategories($course);
        $this->coursesRepository->createCourseCategories($course, $categories);
        return redirect()->route('admin.courses.index')->with('msg', __('courses::message.create.success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $course = $this->coursesRepository->getCourse($id);

        $categoryIds = $this->coursesRepository->getRelatedCategories($course);
        $teachers = $this->teachersRepository->getAllTeachers();

        if (!$course) {
            abort(404);
        }
        $categories = $this->categoriesRepository->getAllCategories();
        $pageTitle = "Cập nhật Khóa học";
        return view('courses::edit', compact('pageTitle', 'course', 'categories', 'categoryIds', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CoursesRequest $request, $id)
    {
        $data = $request->except('_token');
        if (!$data['sale_price']) {
            $data['sale_price'] = 0;
        }
        if (!$data['price']) {
            $data['price'] = 0;
        }
        $updated = $this->coursesRepository->updateCourse($id, $data);
        $categories = $this->getCategories($data);
        $course = $this->coursesRepository->getCourse($id);
        $this->coursesRepository->updateCourseCategories($course, $categories);
        if ($updated) {
            return back()
                ->with('msg', __('courses::message.update.success'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $course = $this->coursesRepository->getCourse($id);

        $status = $this->coursesRepository->deleteCourse($id);

        if ($status && $course && $course->thumbnail) {
            deleteImageFile($course->thumbnail);
        }

        return back()->with('msg', __('courses::message.delete.success'));
    }

    /**
     * Delete multiple items.
     */
    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            return response()->json([
                'message' => 'Vui lòng chọn ít nhất 1 khóa học',
            ], 422);
        }
        // Lấy danh sách thumbnail trước khi xóa DB
        $thumbnails = [];
        foreach ($ids as $id) {
            $course = $this->coursesRepository->find($id);
            if ($course && !empty($course->thumbnail)) {
                $thumbnails[] = $course->thumbnail;
            }
        }

        // Xóa trên DB
        $deleted = $this->coursesRepository->deleteMultiple($ids);

        // Nếu xóa DB ok thì xóa luôn file ảnh
        if ($deleted && !empty($thumbnails)) {
            foreach ($thumbnails as $thumb) {
                deleteImageFile($thumb);
            }
        }

        return response()->json([
            'message' => __('courses::message.delete.success'),
            'deleted' => $deleted,
        ]);
    }
    public function getCategories($data)
    {
        $categories = [];
        foreach ($data['categories'] as $category) {
            $categories[$category] =
                [
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ];
        }
        return $categories;
    }
}

<?php

namespace Modules\Courses\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Courses\Repositories\CoursesRepository;
use Yajra\DataTables\Facades\DataTables;

class CoursesController extends Controller
{
    protected $coursesRepository;

    public function __construct(CoursesRepository $coursesRepository)
    {
        $this->coursesRepository = $coursesRepository;
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
            ->addColumn('select', function ($course) {
                return '<input type="checkbox" class="row-check" value="'.$course->id.'">';
            })
            ->addColumn('edit', function ($course) {
                return '<a href="'.route("admin.courses.edit", $course->id).'" class="btn btn-warning btn-sm">
                <i class="fa fa-edit"></i> Sửa
            </a>';
            })
            ->addColumn('delete', function ($course) {
                $deleteUrl = route("admin.courses.delete", $course->id);
                return '<button type="button" class="btn btn-danger delete-action btn-sm" data-url="'.$deleteUrl.'">
                    <i class="fa fa-trash"></i> Xóa</button>';
            })
            // Edit Column created_at
            ->editColumn('created_at', function ($course) {
                return $course->created_at?->format('Y-m-d H:i:s');
            })
            ->rawColumns(['select', 'edit', 'delete'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $pageTitle = 'Thêm khóa học';
        return view('courses::add', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->coursesRepository->create([
            'name' => $request->name,
            'slug' => $request->slug,
            'detail' => $request->detail,
            'teacher_id' => $request->teacher_id,
            'thumbnail' => $request->thumbnail,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'code' => $request->code,
            'durations' => $request->durations,
            'is_document' => $request->is_document,
            'supports' => $request->supports,
            'status' => $request->status,
        ]);
        return back()->with('msg', __('courses::message.create.success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $course = $this->coursesRepository->find($id);
        if(!$course){
            abort(404);
        }

        $pageTitle = "Cập nhật Khóa học";
        return view('courses::edit', compact('pageTitle', 'course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token');

        $updated = $this->coursesRepository->update($id, $data);

        if ($updated) {
            return redirect()->route('admin.courses.index')
                ->with('msg', __('courses::message.update.success'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $this->coursesRepository->delete($id);
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

        $deleted = $this->coursesRepository->deleteMultiple($ids);

        return response()->json([
            'message' => __('courses::message.delete.success'),
            'deleted' => $deleted,
        ]);
    }
}

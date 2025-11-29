<?php

namespace Modules\Teachers\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Teachers\App\Http\Requests\TeachersRequest;
use Modules\Teachers\Repositories\TeachersRepository;
use Yajra\DataTables\Facades\DataTables;

class TeachersController extends Controller
{
    protected $teachersRepository;

    public function __construct(TeachersRepository $teachersRepository)
    {
        $this->teachersRepository = $teachersRepository;
    }

    /**
     * Danh sách giảng viên
     */
    public function index()
    {
        $pageTitle = 'Danh sách giảng viên';
        return view('teachers::list', compact('pageTitle'));
    }

    /**
     * DataTables
     */
    public function data()
    {
        $teachers = $this->teachersRepository->getAllTeachers();

        return DataTables::of($teachers)
            ->addColumn('select', fn($t) =>
                '<input type="checkbox" class="row-check" value="' . $t->id . '">'
            )
            ->addColumn('image', fn($t) =>
                '<img src="' . asset($t->image ?? 'storage/photos/no-image.png') . '"
                       width="45" height="45" class="rounded">'
            )
            ->addColumn('edit', fn($t) =>
                '<a href="' . route("admin.teachers.edit", $t->id) . '" class="btn btn-warning btn-sm">
                    <i class="fa fa-edit"></i> Sửa
                </a>'
            )
            ->addColumn('delete', fn($t) =>
                '<button type="button" class="btn btn-danger btn-sm delete-action"
                        data-url="' . route("admin.teachers.delete", $t->id) . '">
                    <i class="fa fa-trash"></i> Xóa
                </button>'
            )
            ->editColumn('created_at', fn($t) =>
            $t->created_at?->format('Y-m-d H:i:s')
            )
            ->rawColumns(['select', 'image', 'edit', 'delete'])
            ->toJson();
    }

    /**
     * Form thêm
     */
    public function create()
    {
        $pageTitle = 'Thêm giảng viên';
        return view('teachers::add', compact('pageTitle'));
    }

    /**
     * Lưu giảng viên
     */
    public function store(TeachersRequest $request)
    {
        $data = $request->only(['name', 'slug', 'description', 'exp', 'image']);

        $this->teachersRepository->create($data);

        return back()->with('msg', 'Thêm giảng viên thành công!');
    }

    /**
     * Form sửa
     */
    public function edit($id)
    {
        $teacher = $this->teachersRepository->find($id);

        if (!$teacher) {
            abort(404);
        }

        $pageTitle = "Cập nhật giảng viên";

        return view('teachers::edit', compact('pageTitle', 'teacher'));
    }

    /**
     * Cập nhật giảng viên
     */
    public function update(TeachersRequest $request, $id)
    {
        $data = $request->only(['name', 'slug', 'description', 'exp', 'image']);

        $this->teachersRepository->update($id, $data);

        return redirect()->route('admin.teachers.index')
            ->with('msg', 'Cập nhật giảng viên thành công!');
    }

    /**
     * Xóa 1 giảng viên
     */
    public function delete($id)
    {
        $this->teachersRepository->delete($id);

        return back()->with('msg', 'Xóa giảng viên thành công!');
    }

    /**
     * Xóa nhiều giảng viên
     */
    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids ?? [];

        if (empty($ids)) {
            return response()->json([
                'message' => 'Vui lòng chọn ít nhất 1 giảng viên!'
            ], 422);
        }

        $deleted = $this->teachersRepository->deleteMultiple($ids);

        return response()->json([
            'message' => 'Đã xóa thành công!',
            'deleted' => $deleted
        ]);
    }
}

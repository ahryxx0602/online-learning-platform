<?php

namespace Modules\Teachers\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Modules\Teachers\App\Http\Requests\TeachersRequest;
use Modules\Teachers\Repositories\TeachersRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;

class TeachersController extends Controller
{
    protected $teachersRepository;

    public function __construct(TeachersRepositoryInterface $teachersRepository)
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
        $data = $request->except('_token');

        $this->teachersRepository->update($id, $data);

        return redirect()->route('admin.teachers.index')
            ->with('msg', __('teachers::messages.update.success'));
    }

    /**
     * Xóa 1 giảng viên
     */
    public function delete($id)
    {
        $teacher = $this->teachersRepository->find($id);

        $status = $this->teachersRepository->delete($id);
    if($status){
            $image = $teacher->image;
            deleteImageFile($image);
        }

        return back()->with('msg', __('teachers::messages.update.success'));
    }

    /**
     * Xóa nhiều giảng viên
     */
    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids ?? [];

        if (empty($ids)) {
            return response()->json([
                'message' => 'Vui lòng chọn ít nhất 1 giảng viên',
            ], 422);
        }

        // Lấy danh sách teacher trước khi xoá DB để còn biết đường xoá file
        $teachers = [];
        foreach ($ids as $id) {
            $teacher = $this->teachersRepository->find($id);
            if ($teacher) {
                $teachers[] = $teacher;
            }
        }

        // Xóa trên DB
        $deleted = $this->teachersRepository->deleteMultiple($ids);

        // Nếu xóa DB thành công thì xóa luôn file ảnh
        if ($deleted && !empty($teachers)) {
            foreach ($teachers as $teacher) {
                if (!empty($teacher->image)) {
                    deleteImageFile($teacher->image);
                }
            }
        }

        return response()->json([
            'message' => __('teachers::messages.delete.success'),
            'deleted' => $deleted,
        ]);
    }
}

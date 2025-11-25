<?php

namespace Modules\Categories\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Categories\app\Http\Requests\CategoriesRequest;
use Modules\Categories\Repositories\CategoriesRepository;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    protected $categoriesRepository;

    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    public function index()
    {
        $pageTitle = 'Danh sách danh mục';
        return view('categories::list', compact('pageTitle'));
    }

    public function data()
    {
        $categories = $this->categoriesRepository->getAllForDataTable();

        return DataTables::of($categories)
            ->addColumn('select', function ($category) {
                return '<input type="checkbox" class="row-check" value="'.$category->id.'">';
            })
            ->addColumn('link', function ($category) {
                $url = url('/category/' . $category->slug);
                return '<a href="'.$url.'" target="_blank" class="badge badge-info" style="cursor:pointer;">
                            '.e($category->slug).'
                        </a>';
            })
            ->addColumn('edit', function ($category) {
                return '<a href="'.route('admin.categories.edit', $category->id).'" 
                            class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i> Sửa
                        </a>';
            })
            ->addColumn('delete', function ($category) {
                $deleteUrl = route('admin.categories.delete', $category->id);
                return '<button type="button" 
                            class="btn btn-danger btn-sm delete-action" 
                            data-url="'.$deleteUrl.'">
                            <i class="fa fa-trash"></i> Xóa
                        </button>';
            })
            ->editColumn('created_at', function ($category) {
                return $category->created_at?->format('Y-m-d H:i:s');
            })
            ->rawColumns(['select', 'link', 'edit', 'delete'])
            ->toJson();
    }

    public function create()
    {
        $pageTitle = 'Thêm danh mục';
        $parents = $this->categoriesRepository->getParentOptions();

        return view('categories::add', compact('pageTitle', 'parents'));
    }

    public function store(CategoriesRequest $request)
    {
        $this->categoriesRepository->create([
            'name' => $request->name,
            'slug' => $request->slug,
            'parent_id' => $request->parent_id ?? 0,
        ]);

        return redirect()
    ->route('admin.categories.index')
    ->with('msg', __('categories::message.create.success'));
    }

    public function edit($id)
    {
        $category = $this->categoriesRepository->find($id);
        $pageTitle = 'Cập nhật danh mục';
        $parents = $this->categoriesRepository->getParentOptions($id);

        return view('categories::edit', compact('pageTitle', 'category', 'parents'));
    }

    public function update(CategoriesRequest $request, $id)
    {
        $this->categoriesRepository->update($id, [
            'name' => $request->name,
            'slug' => $request->slug,
            'parent_id' => $request->parent_id ?? 0,
        ]);

        return redirect()
    ->route('admin.categories.index')
    ->with('msg', __('categories::message.update.success'));
    }

    public function delete($id)
    {
        $this->categoriesRepository->delete($id);
        return back()->with('msg', __('categories::message.delete.success'));
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return response()->json([
                'message' => __('categories::message.delete.required'),
            ], 422);
        }

        $deleted = $this->categoriesRepository->deleteMultiple($ids);

        return response()->json([
            'message' => __('categories::message.delete.success'),
            'deleted' => $deleted,
        ]);
    }
}
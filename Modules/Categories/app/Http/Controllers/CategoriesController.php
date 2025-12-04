<?php

namespace Modules\Categories\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Categories\app\Http\Requests\CategoriesRequest;
use Modules\Categories\Repositories\CategoriesRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    protected $categoriesRepository;

    public function __construct(CategoriesRepositoryInterface $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    public function index()
    {
        $pageTitle = 'Danh sách danh mục';
        return view('categories::list', compact('pageTitle'));
    }

    public function data() {
        $categories = $this->categoriesRepository->getCategories();
        $categories = DataTables::of($categories)
//            ->addColumn('select', function ($category) { return '<input type="checkbox" class="row-check" value="'.$category->id.'">'; })
//            ->addColumn('link', function ($category) { $url = url('/category/' . $category->slug); return '<a href="'.$url.'" target="_blank" class="badge badge-info" style="cursor:pointer;"> '.e($category->slug).' </a>'; })
//            ->addColumn('edit', function ($category) { return '<a href="'.route('admin.categories.edit', $category->id).'" class="btn btn-warning btn-sm"> <i class="fa fa-edit"></i> Sửa </a>'; })
//            ->addColumn('delete', function ($category) { return '<a href="'.route('admin.categories.delete', $category['id']).'" class="btn btn-danger btn-sm delete-action"> <i class="fa fa-trash"></i> Sửa </a>'; })
//            ->editColumn('created_at', function ($category) { return $category->created_at?->format('Y-m-d H:i:s'); })
//            ->rawColumns(['select', 'link', 'edit', 'delete'])
            ->toArray();
            $categories['data'] = $this->getCategoriesTable($categories['data']);
            return $categories;
    }


    public function getCategoriesTable($categories, $char='',&$result = []) {
        if(!empty($categories)){
            foreach ($categories as $key => $category) {
                $row = $category;
                $row['select'] = '<input type="checkbox" class="row-check" value="'.$category['id'].'">';
                $row['name'] = $char.$row['name'];
                $row['edit'] = '<a href="'.route('admin.categories.edit', $category['id']).'" class="btn btn-warning btn-sm"> <i class="fa fa-edit"></i> Sửa </a>';
                $row['delete'] = '<a href="'.route('admin.categories.delete', $category['id']).'" class="btn btn-danger btn-sm delete-action"> <i class="fa fa-trash"></i> Sửa </a>';
                $url = url('/category/' . $category['slug']); $row['link'] = '<a target="_blank" href="'.$url.'" target="_blank" class="badge badge-info" style="cursor:pointer;"> '.e($category['slug']).' </a>';
                $row['created_at'] = $category['created_at']
                    ? date('Y-m-d H:i:s', strtotime($category['created_at']))
                    : null;
                unset($row['sub_categories']);
                unset($row['updated_at']);
                $result[] = $row;
                if(!empty($category['sub_categories'])){
                    $this->getCategoriesTable($category['sub_categories'],
                    $char."|--", $result); } } }
        return $result;
    }

    public function create()
    {
        $pageTitle = 'Thêm danh mục';
        $categories = $this->categoriesRepository->getAllCategories();

        return view('categories::add', compact('pageTitle', 'categories'));
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
        $categories = $this->categoriesRepository->getAllCategories();

        return view('categories::edit', compact('pageTitle', 'category', 'categories'));
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

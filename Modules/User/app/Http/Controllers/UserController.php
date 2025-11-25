<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\User\app\Http\Requests\UserRequest;
use Modules\User\Repositories\UserRepository;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Danh sách người dùng';
        // $users = $this->userRepository->getUser(5);
        // $check = $this->userRepository->checkPassword('1234567',1);
        // dd($check);
        return view('user::list', compact('pageTitle'));
    }

    public function data()
    {
        $users = $this->userRepository->getAllUsers();
         return DataTables::of($users)
             ->addColumn('select', function ($user) {
                 return '<input type="checkbox" class="row-check" value="'.$user->id.'">';
             })
             ->addColumn('edit', function ($user) {
                 return '<a href="'.route("admin.users.edit", $user->id).'" class="btn btn-warning">
                <i class="fa fa-edit"></i> Sửa
            </a>';
             })
            ->addColumn('delete', function ($user) {
                $deleteUrl = route("admin.users.delete", $user->id);
                return '<button type="button" class="btn btn-danger delete-action" data-url="'.$deleteUrl.'">
                    <i class="fa fa-trash"></i> Xóa</button>';
            })
             // Edit Column created_at
             ->editColumn('created_at', function ($user) {
                 return $user->created_at?->format('Y-m-d H:i:s');
             })
             ->rawColumns(['select', 'edit', 'delete'])
             ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Thêm người dùng';
        return view('user::add', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $this->userRepository->create([
            'name' => $request->name,
            'email' => $request->email,
            'group_id' => $request->group_id,
            'password' => bcrypt($request->password),
        ]);
        return back()->with('msg', __('user::message.create.success'));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('users::detail');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = $this->userRepository->find($id);
        if(!$user){
            abort(404);
        }

        $pageTitle = "Cập nhật người dùng";
        return view('user::edit', compact('pageTitle', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id)
    {
        $data = $request->except('_token', 'password');
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }
        $status = $this->userRepository->update($id, $data);
        if($status){
            return redirect()->route('admin.users.index')->with('msg', __('user::message.update.success'));
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $this->userRepository->delete($id);
        return back()->with('msg', __('user::message.delete.success'));
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            return response()->json([
                'message' => 'Vui lòng chọn ít nhất 1 người dùng',
            ], 422);
        }

        $deleted = $this->userRepository->deleteMultiple($ids);

        return response()->json([
            'message' => __('user::message.delete.success'),
            'deleted' => $deleted,
        ]);
    }
}

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
             ->addColumn('edit', function ($user) {
                 return '<a href="'.route("admin.users.edit", $user->id).'" class="btn btn-warning">
                <i class="fa fa-edit"></i> Sửa
            </a>';
             })
             ->addColumn('delete', function ($user) {
                 return '<a href="#" class="btn btn-danger"><i class="fa fa-trash"></i> Xóa</a>';
             })
             // Edit Column created_at
             ->editColumn('created_at', function ($user) {
                 return $user->created_at?->format('Y-m-d H:i:s');
             })
             ->rawColumns(['edit', 'delete'])
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
        return redirect()->route('admin.users.index')->with('msg', __('user::message.create_success'));
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
        dd(route('admin.users.edit', 1));
        // return view('users::edit');
        return "Thanhf";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}

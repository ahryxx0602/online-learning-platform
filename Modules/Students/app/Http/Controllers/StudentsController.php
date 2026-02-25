<?php

namespace Modules\Students\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Students\App\Http\Requests\StudentRequest;
use Modules\Students\Repositories\StudentsRepository;
use Modules\Students\Repositories\StudentsRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    protected $studentsRepository;

    public function __construct(StudentsRepositoryInterface $studentsRepository)
    {
        $this->studentsRepository = $studentsRepository;
    }


    public function index()
    {
        $pageTitle = 'Danh sách học viên';
        return view('students::list', compact('pageTitle'));
    }

    public function data()
    {
        $students = $this->studentsRepository->getAllStudents();
        return DataTables::of($students)
            ->addColumn('select', function ($student) {
                return '<input type="checkbox" class="row-check" value="'.$student->id.'">';
            })
            ->addColumn('edit', function ($student) {
                return '<a href="'.route("admin.students.edit", $student->id).'" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i> Sửa
                        </a>';
            })
            ->addColumn('delete', function ($student) {
                $deleteUrl = route("admin.students.delete", $student->id);
                return '<button type="button" class="btn btn-danger delete-action btn-sm" data-url="'.$deleteUrl.'">
                            <i class="fa fa-trash"></i> Xóa
                        </button>';
            })
            ->rawColumns(['select', 'edit', 'delete'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Tạo mới học viên';
        return view('students::add', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        $data = $request->validated();
        
        $data['password'] = bcrypt($data['password']);

        $data['status'] = $request->status ?? 0; 

        $this->studentsRepository->create($data);

        return redirect()->route('admin.students.index')->with('msg', __('user::message.create.success'));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('students::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
        $student = $this->studentsRepository->find($id);
        if(!$student){
            abort(404);
        }

        $pageTitle = "Cập nhật người dùng";
        return view('students::edit', compact('pageTitle', 'student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, $id)
    {
        $data = $request->except('_token', '_method', 'password');
        
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $data['status'] = $request->status ?? 0;

        $status = $this->studentsRepository->update($id, $data);

        if ($status) {
            return redirect()->route('admin.students.index')
                ->with('msg', __('user::message.update.success'));
        }
        
        return back()->with('error', 'Cập nhật thất bại, vui lòng thử lại!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}

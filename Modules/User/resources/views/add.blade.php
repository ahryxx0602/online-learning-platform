@extends('layouts.backend')
@section('content')
    <form action="" method="post">
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Tên</label>
                    <input type="text" class="form-control" placeholder="Nhập tên..." value="">
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Email</label>
                    <input type="text" class="form-control" placeholder="Nhập email..." value="">
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Chọn nhóm người dùng</label>
                    <select name="" id="" class="form-control">
                        <option value="">Chọn nhóm</option>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Mật khẩu</label>
                    <input type="password" class="form-control" placeholder="Nhập mật khẩu..." value="">
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Lưu lại</button>
                <a href="{{route('admin.users.index')}}" class="btn btn-secondary">Hủy</a>
            </div>
        </div>

    </form>
@endsection


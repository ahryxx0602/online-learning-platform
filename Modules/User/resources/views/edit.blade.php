@extends('layouts.backend')
@section('content')

    @if(session('msg'))
        <div class="alert alert-success">
            {{session('msg')}}
        </div>
    @endif

    <form action="" method="post">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Tên</label>
                    <input
                        name="name" type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Nhập tên..." value="{{old('name') ?? $user->name}}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Email</label>
                    <input name="email" type="text"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Nhập email..." value="{{old('email') ?? $user->email}}">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Chọn nhóm người dùng</label>
                    <select name="group_id" id="" class="form-control @error('group_id') is-invalid @enderror">
                        <option value="">Chọn nhóm</option>
                        <option value="1">Administrator</option>
                    </select>
                    @error('group_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Mật khẩu</label>
                    <input name="password" type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Nhập mật khẩu..." value="">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Lưu lại</button>
                <a href="{{route('admin.users.index')}}" class="btn btn-secondary">Hủy</a>
            </div>
        </div>
    </form>
@endsection


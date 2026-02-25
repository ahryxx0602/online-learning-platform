@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Chỉnh Sửa Hồ Sơ Học Viên</h1>
        </div>

        @if(session('msg'))
            <div class="alert alert-success">
                {{ session('msg') }}
            </div>
        @endif

        <form action="{{ route('admin.students.update', $student->id) }}" method="post">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="name">Họ và tên học viên</label>
                        <input name="name" type="text" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Ví dụ: Nguyễn Văn A..." 
                            value="{{ old('name') ?? $student->name }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-6">
                    <div class="mb-3">
                        <label for="email">Email (Tài khoản đăng nhập)</label>
                        <input name="email" type="email" id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="hocvien@email.com..." 
                               value="{{ old('email') ?? $student->email }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-6">
                    <div class="mb-3">
                        <label for="password">Mật khẩu mới (Để trống nếu không muốn đổi)</label>
                        <input name="password" type="password" id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Nhập mật khẩu mới...">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-6">
                    <div class="mb-3">
                        <label for="phone">Số điện thoại</label>
                        <input name="phone" type="text" id="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               placeholder="Nhập số điện thoại..." 
                               value="{{ old('phone') ?? $student->phone }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-6">
                    <div class="mb-3">
                        <label for="address">Địa chỉ</label>
                        <input name="address" type="text" id="address"
                               class="form-control @error('address') is-invalid @enderror"
                               placeholder="Nhập địa chỉ học viên..." 
                               value="{{ old('address') ?? $student->address }}">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-6">
                    <div class="mb-3">
                        <label for="status">Trạng thái tài khoản</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="1" {{ (old('status') ?? $student->status) == '1' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ (old('status') ?? $student->status) == '0' ? 'selected' : '' }}>Khóa / Chưa kích hoạt</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật hồ sơ
                    </button>
                    <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Hủy
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
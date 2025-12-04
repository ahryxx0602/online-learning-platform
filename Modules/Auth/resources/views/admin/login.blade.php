@extends('layouts.auth')


@section('content')
    <div class="row gx-4 align-items-center">
        {{-- Bên trái: giới thiệu ngắn, icon, bullet lợi ích --}}
        <div class="col-md-5 d-none d-md-flex flex-column justify-content-center pe-md-4 border-end">
            <div class="mb-4">
                <span class="rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm"
                      style="width:60px;height:60px;background:linear-gradient(135deg,#4e73df,#1cc88a);">
                    <i class="fas fa-graduation-cap text-white"></i>
                </span>
            </div>
            <h2 class="h5 text-gray-900 mb-3">Nền tảng học trực tuyến Ahryxx</h2>
            <ul class="list-unstyled small text-muted mb-0">
                <li class="mb-2">
                    <i class="fas fa-check-circle text-success me-1"></i>
                    Quản lý khoá học và học viên tập trung.
                </li>
                <li class="mb-2">
                    <i class="fas fa-check-circle text-success me-1"></i>
                    Theo dõi tiến độ học chi tiết, trực quan.
                </li>
                <li class="mb-2">
                    <i class="fas fa-check-circle text-success me-1"></i>
                    Hệ thống báo cáo, thống kê dành cho quản trị.
                </li>
            </ul>
        </div>

        {{-- Bên phải: form đăng nhập --}}
        <div class="col-md-7 mt-4 mt-md-0">
            <div class="text-center mb-4">
                <h1 class="h4 text-gray-900 mb-1">{{ $pageTitle ?? 'Đăng nhập' }}</h1>
                <p class="text-muted small mb-0">
                    Chào mừng bạn quay lại hệ thống quản trị khoá học.
                </p>
            </div>

            @if (session('status'))
                <div class="alert alert-success small" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger small" role="alert">
                    <strong>Đăng nhập không thành công.</strong> Vui lòng kiểm tra lại thông tin bên dưới.
                </div>
            @endif

            <form class="user mt-3" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input
                        type="email"
                        name="email"
                        class="form-control form-control-user @error('email') is-invalid @enderror"
                        id="email"
                        aria-describedby="emailHelp"
                        placeholder="Nhập địa chỉ email..."
                        value="{{ old('email') }}"
                        autocomplete="email"
                        autofocus
                    >
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input
                        type="password"
                        name="password"
                        class="form-control form-control-user @error('password') is-invalid @enderror"
                        id="password"
                        placeholder="Mật khẩu"
                        autocomplete="current-password"
                    >
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox small">
                        <input
                            type="checkbox"
                            class="custom-control-input"
                            name="remember"
                            id="remember"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <label class="custom-control-label" for="remember">
                            Ghi nhớ đăng nhập
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-user btn-block">
                    Đăng nhập
                </button>
            </form>

            <hr>
            <div class="text-center">
                @if (Route::has('password.request'))
                    <a class="small" href="{{ route('password.request') }}">Quên mật khẩu?</a>
                @endif
            </div>
            <div class="text-center">
                @if (Route::has('register'))
                    <span class="small text-muted">Chưa có tài khoản?</span>
                    <a class="small" href="{{ route('register') }}">Đăng ký ngay</a>
                @endif
            </div>
        </div>
    </div>
@endsection

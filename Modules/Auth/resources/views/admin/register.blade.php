@extends('layouts.auth')

@section('title', 'Đăng ký tài khoản')

@section('content')
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
    </div>

    <form class="user" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input
                    type="text"
                    class="form-control form-control-user @error('name') is-invalid @enderror"
                    id="name"
                    name="name"
                    placeholder="Full Name"
                    value="{{ old('name') }}"
                    required
                    autocomplete="name"
                    autofocus
                >
                @error('name')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-sm-6">
                <input
                    type="email"
                    class="form-control form-control-user @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    placeholder="Email Address"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                >
                @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input
                    type="password"
                    class="form-control form-control-user @error('password') is-invalid @enderror"
                    id="password"
                    name="password"
                    placeholder="Password"
                    required
                    autocomplete="new-password"
                >
                @error('password')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-sm-6">
                <input
                    type="password"
                    class="form-control form-control-user"
                    id="password-confirm"
                    name="password_confirmation"
                    placeholder="Repeat Password"
                    required
                    autocomplete="new-password"
                >
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-user btn-block">
            Register Account
        </button>
    </form>

    <hr>
    <div class="text-center">
        @if (Route::has('password.request'))
            <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
        @endif
    </div>
    <div class="text-center">
        @if (Route::has('login'))
            <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
        @endif
    </div>
@endsection

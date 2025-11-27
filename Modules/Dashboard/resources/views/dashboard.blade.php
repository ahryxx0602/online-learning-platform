@extends('layouts.backend')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="row">

        {{-- Users --}}
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Người dùng
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalUsers ?? 0 }}
                            </div>
                        </div>

                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>

                    </div>

                    <div class="mt-2 text-right">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">
                            Quản lý
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Categories --}}
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Danh mục
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalCategories ?? 0 }}
                            </div>
                        </div>

                        <div class="col-auto">
                            <i class="fas fa-folder fa-2x text-gray-300"></i>
                        </div>

                    </div>

                    <div class="mt-2 text-right">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-success">
                            Quản lý
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Courses --}}
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Khóa học
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalCourses ?? 0 }}
                            </div>
                        </div>

                        <div class="col-auto">
                            <i class="fas fa-book-open fa-2x text-gray-300"></i>
                        </div>

                    </div>

                    <div class="mt-2 text-right">
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-sm btn-warning text-white">
                            Quản lý
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

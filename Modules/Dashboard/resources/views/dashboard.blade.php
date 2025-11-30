@extends('layouts.backend')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="row">

        {{-- Users --}}
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 dashboard-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Người dùng
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span class="counter" data-target="{{ $totalUsers ?? 0 }}">0</span>
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
            <div class="card border-left-success shadow h-100 py-2 dashboard-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Danh mục
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span class="counter" data-target="{{ $totalCategories ?? 0 }}">0</span>
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
            <div class="card border-left-warning shadow h-100 py-2 dashboard-card">
            <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Khóa học
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span class="counter" data-target="{{ $totalCourses ?? 0 }}">0</span>
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

        {{-- Teachers --}}
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 dashboard-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Giảng viên
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span class="counter" data-target="{{ $totalTeachers ?? 0 }}">0</span>
                            </div>
                        </div>

                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>

                    </div>

                    <div class="mt-2 text-right">
                        <a href="{{ route('admin.teachers.index') }}" class="btn btn-sm btn-info text-white">
                            Quản lý
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
@push('styles')
    <style>
        .dashboard-card {
            transition: all 0.25s ease;
            cursor: pointer;
        }

        .dashboard-card:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        /* Border sáng hơn khi hover */
        .border-left-primary:hover     { border-left: .35rem solid #2e59d9 !important; }
        .border-left-success:hover     { border-left: .35rem solid #1cc88a !important; }
        .border-left-warning:hover     { border-left: .35rem solid #f6c23e !important; }
        .border-left-info:hover        { border-left: .35rem solid #36b9cc !important; }

        .dashboard-card .col-auto i {
            transition: transform 0.25s ease, color 0.25s ease;
        }
si
        .dashboard-card:hover .col-auto i {
            transform: scale(1.25); /* phóng icon */
            color: rgba(0,0,0,0.25) !important; /* nhạt nhẹ để nổi bật */
        }
    </style>
@endpush

@push('scripts')
    <script>
        const counters = document.querySelectorAll('.counter');

        counters.forEach(counter => {
            counter.innerText = '0';

            const updateCounter = () => {
                const target = +counter.getAttribute('data-target');
                const current = +counter.innerText;

                // tăng chậm hay nhanh tùy chỉnh
                const increment = Math.ceil(target / 80);

                if (current < target) {
                    counter.innerText = current + increment;
                    setTimeout(updateCounter, 20); // tốc độ chạy
                } else {
                    counter.innerText = target.toLocaleString('vi-VN');
                }
            };

            updateCounter();
        });
    </script>
@endpush

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    {{-- Tiêu đề / breadcrumb ngắn --}}
    <div class="d-none d-sm-inline-block mr-auto">
        <span class="font-weight-bold text-primary">
            {{ $pageTitle ?? 'Bảng điều khiển' }}
        </span>
        <span class="small text-muted d-none d-md-inline">
            &nbsp;•&nbsp; Ahryxx Course Admin
        </span>
    </div>

    <!-- Topbar Navbar -->
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        {{-- Ngày hiện tại --}}
        <li class="nav-item d-none d-sm-flex align-items-center mr-3">
        <span class="text-muted small">
            <i class="far fa-calendar-alt mr-1"></i>
            {{ now()->format('d/m/Y') }}
        </span>
        </li>

        {{-- Địa điểm + thời tiết --}}
        <li class="nav-item d-none d-md-flex align-items-center mr-3">
        <span class="text-muted small">
            <i class="fas fa-map-marker-alt mr-1"></i>
            {{ $currentLocation ?? 'Đà Nẵng' }}
            <span class="mx-1">•</span>
            <i class="fas fa-cloud-sun mr-1"></i>
            {{ $currentWeather['temp'] ?? '28°C' }}
            <span class="d-none d-lg-inline">
                ({{ $currentWeather['status'] ?? 'Trời đẹp' }})
            </span>
        </span>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                Xin chào, {{ auth()->user()->name ?? 'Admin' }}
                <span class="badge badge-pill badge-primary ml-1">Quản trị viên</span>
            </span>
                <img class="img-profile rounded-circle"
                     src="{{ asset('backend/img/undraw_profile.svg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Tài khoản
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Đăng xuất
                </a>
            </div>
        </li>

    </ul>
</nav>
<!-- End of Topbar -->

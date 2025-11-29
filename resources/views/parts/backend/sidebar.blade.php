<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="sidebar-brand-text mx-3">E-Learning Admin</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Quản lý nội dung</div>

    <!-- Categories -->
    <li class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.categories.index') }}">
            <i class="fas fa-folder"></i>
            <span>Danh mục</span>
        </a>
    </li>

    <!-- Courses -->
    <li class="nav-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.courses.index') }}">
            <i class="fas fa-book-open"></i>
            <span>Khóa học</span>
        </a>
    </li>

    <!-- Lessons (future) -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-video"></i>
            <span>Bài giảng</span>
        </a>
    </li>

    <!-- Teachers -->
    <li class="nav-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.teachers.index') }}">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Giảng viên</span>
        </a>
    </li>

    <!-- Documents -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-file-alt"></i>
            <span>Tài liệu</span>
        </a>
    </li>

    <!-- Videos -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-photo-video"></i>
            <span>Video</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Tin tức & Nội dung</div>

    <!-- News categories -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-list"></i>
            <span>Danh mục tin tức</span>
        </a>
    </li>

    <!-- Posts -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-newspaper"></i>
            <span>Tin tức</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Người dùng & Doanh thu</div>

    <!-- Students -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-user-graduate"></i>
            <span>Học viên</span>
        </a>
    </li>

    <!-- Orders -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-shopping-cart"></i>
            <span>Đơn hàng</span>
        </a>
    </li>

    <!-- Order Status -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-tasks"></i>
            <span>Trạng thái đơn hàng</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Hệ thống</div>

    <!-- Users -->
    <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="fas fa-users-cog"></i>
            <span>Quản trị hệ thống</span>
        </a>
    </li>

    <!-- Groups -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-user-shield"></i>
            <span>Phân quyền</span>
        </a>
    </li>

    <!-- Settings -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-cogs"></i>
            <span>Thiết lập hệ thống</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End Sidebar -->

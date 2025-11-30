<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="sidebar-brand-text mx-3">E-Learning Admin</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Quản lý chung</div>

    @php
        $isTrainingActive = request()->routeIs('admin.categories.*') ||
                            request()->routeIs('admin.courses.*') ||
                            request()->routeIs('admin.teachers.*');
    @endphp
    <li class="nav-item {{ $isTrainingActive ? 'active' : '' }}">
        <a class="nav-link {{ $isTrainingActive ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseTraining"
           aria-expanded="{{ $isTrainingActive ? 'true' : 'false' }}" aria-controls="collapseTraining">
            <i class="fas fa-book-open"></i>
            <span>Quản lý Đào tạo</span>
        </a>
        <div id="collapseTraining" class="collapse {{ $isTrainingActive ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Nội dung khóa học:</h6>
                <a class="collapse-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">Danh mục</a>
                <a class="collapse-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}" href="{{ route('admin.courses.index') }}">Khóa học</a>
                <a class="collapse-item" href="#">Bài giảng</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Tài nguyên:</h6>
                <a class="collapse-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}" href="{{ route('admin.teachers.index') }}">Giảng viên</a>
                <a class="collapse-item" href="#">Tài liệu & Video</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNews"
           aria-expanded="false" aria-controls="collapseNews">
            <i class="fas fa-newspaper"></i>
            <span>Quản lý Tin tức</span>
        </a>
        <div id="collapseNews" class="collapse" aria-labelledby="headingNews" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">Danh mục tin</a>
                <a class="collapse-item" href="#">Bài viết</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBusiness"
           aria-expanded="false" aria-controls="collapseBusiness">
            <i class="fas fa-users"></i>
            <span>Học viên & Doanh thu</span>
        </a>
        <div id="collapseBusiness" class="collapse" aria-labelledby="headingBusiness" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">Danh sách học viên</a>
                <a class="collapse-item" href="#">Đơn hàng</a>
                <a class="collapse-item" href="#">Trạng thái đơn</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Hệ thống</div>

    @php
        $isSystemActive = request()->routeIs('admin.users.*');
    @endphp
    <li class="nav-item {{ $isSystemActive ? 'active' : '' }}">
        <a class="nav-link {{ $isSystemActive ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseSystem"
           aria-expanded="{{ $isSystemActive ? 'true' : 'false' }}" aria-controls="collapseSystem">
            <i class="fas fa-cogs"></i>
            <span>Cấu hình Hệ thống</span>
        </a>
        <div id="collapseSystem" class="collapse {{ $isSystemActive ? 'show' : '' }}" aria-labelledby="headingSystem" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Quản trị viên</a>
                <a class="collapse-item" href="#">Phân quyền (Roles)</a>
                <a class="collapse-item" href="#">Thiết lập chung</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

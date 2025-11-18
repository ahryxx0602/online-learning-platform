<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">{{ $pageTitle }}</h1>
        <ol class="breadcrumb mb-0 mt-2">
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}"></a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
        </ol>
    </div>

    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i>
        Generate Report
    </a>
</div>

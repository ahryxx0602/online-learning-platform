@extends('layouts.backend')
@section('content')

    <div class="d-flex mb-3">
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary mr-2">Thêm mới</a>

        <button
            type="button"
            class="btn btn-danger"
            id="bulk-delete-btn"
            data-url="{{ route('admin.teachers.deleteMultiple') }}"
            disabled
        >
            Xóa đã chọn
        </button>
    </div>

    @if(session('msg'))
        <div class="alert alert-success">
            {{ session('msg') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách giảng viên</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="dataTable" width="100%">
                    <thead>
                    <tr>
                        <th width="30">
                            <input type="checkbox" id="check-all">
                        </th>
                        <th>Ảnh</th>
                        <th>Tên</th>
                        <th>Slug</th>
                        <th>Kinh nghiệm</th>
                        <th>Ngày tạo</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @include('parts.backend.delete-action')
@endsection

@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            const table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.teachers.data') }}",
                columns: [
                    { data: "select", orderable: false, searchable: false },
                    { data: "image", searchable: false, orderable: false },
                    { data: "name" },
                    { data: "slug" },
                    { data: "exp" },
                    {
                        data: "created_at",
                        render: function (data) {
                            let d = new Date(data.replace(' ', 'T'));
                            return d.toLocaleDateString('vi-VN') + ' ' + d.toLocaleTimeString('vi-VN');
                        }
                    },
                    { data: "edit", orderable: false, searchable: false },
                    { data: "delete", orderable: false, searchable: false },
                ]
            });

            window.teacherDataTable = table;

            table.on('draw', function () {
                const masterCheckbox = document.getElementById('check-all');
                if (masterCheckbox) masterCheckbox.checked = false;
                if (window.updateBulkDeleteState) window.updateBulkDeleteState();
            });
        });
    </script>
@endpush

@extends('layouts.backend')
@section('content')
<div class="d-flex mb-3">
    <a href="{{route('admin.users.create')}}" class="btn btn-primary mr-2">Thêm mới</a>

    <button
        type="button"
        class="btn btn-danger"
        id="bulk-delete-btn"
        data-url="{{ route('admin.users.deleteMultiple') }}"
        disabled
    >
        Xóa đã chọn
    </button>
</div>

    @if(session('msg'))
        <div class="alert alert-success">
            {{session('msg')}}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách người dùng</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%">
                    <thead>
                    <tr>
                        <th width="30">
                            <input type="checkbox" id="check-all">
                        </th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Nhóm</th>
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
                ajax: "{{ route('admin.users.data') }}",
                columns: [
                    { data: "select", orderable: false, searchable: false },
                    { data: "name" },
                    { data: "email" },
                    {
                        data: "group_id",
                        render: function (data) {
                            return data == 1
                                ? '<span class="badge badge-primary">Admin</span>'
                                : '<span class="badge badge-secondary">User</span>';
                        }
                    },
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

            window.userDataTable = table;

            table.on('draw', function () {
                const masterCheckbox = document.getElementById('check-all');
                if (masterCheckbox) {
                    masterCheckbox.checked = false;
                }
                if (window.updateBulkDeleteState) {
                    window.updateBulkDeleteState();
                }
            });
        });
    </script>
@endpush

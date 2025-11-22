@extends('layouts.backend')
@section('content')
    <p><a href="{{route('admin.users.create')}}" class="btn btn-primary">Thêm mới</a></p>

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
@endsection

@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.users.data') }}",
                columns: [
                    { data: "name" },
                    { data: "email" },

                    // Hiển thị Group theo tên (1 = Admin, 2 = User, ...)
                    {
                        data: "group_id",
                        render: function (data) {
                            return data == 1
                                ? '<span class="badge badge-primary">Admin</span>'
                                : '<span class="badge badge-secondary">User</span>';
                        }
                    },

                    // Format ngày đẹp hơn
                    {
                        data: "created_at",
                        render: function (data) {
                            let d = new Date(data.replace(' ', 'T'));
                            return d.toLocaleDateString('vi-VN') + ' ' + d.toLocaleTimeString('vi-VN');
                        }
                    },

                    // Nút sửa
                    {
                        data: "id",
                        orderable: false,
                        searchable: false,
                        render: function(id){
                            return `<a href="/admin/users/${id}/edit" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i> Sửa
                                </a>`;
                        }
                    },

                    // Nút xoá
                    {
                        data: "id",
                        orderable: false,
                        searchable: false,
                        render: function(id){
                            return `<a href="/admin/users/${id}/delete" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn có chắc muốn xóa?')">
                                    <i class="fa fa-trash"></i> Xóa
                                </a>`;
                        }
                    },
                ]
            });
        });
    </script>
@endpush

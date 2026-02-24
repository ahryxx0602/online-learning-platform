@extends('layouts.backend')

@section('content')
    <div class="d-flex mb-3">
        <a href="{{ route('admin.lessons.create', ['courseId' => $courseId]) }}" class="btn btn-primary mr-2">Thêm mới</a>
        <a href="{{ route('admin.lessons.sort', ['courseId' => $courseId]) }}" class="btn btn-success mr-2">Sắp xếp bài giảng</a>
        <button type="button" class="btn btn-danger" id="bulk-delete-btn"
            data-url="{{ route('admin.lessons.deleteMultiple') }}" disabled>
            Xóa đã chọn
        </button>
    </div>

    @if (session('msg'))
        <div class="alert alert-success">
            {{ session('msg') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách bài giảng</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th width="30">
                                <input type="checkbox" id="check-all">
                            </th>
                            <th>Tên bài giảng</th>
                            <th>Học thử</th>
                            <th>Lượt xem</th>
                            <th>Thời lượng</th>
                            <th>Thêm</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary text-white mr-2">Quay lại danh sách khóa học</a>


    @include('parts.backend.delete-action')
@endsection

@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            const ajaxUrl = "{{ route('admin.lessons.data', ['courseId' => $courseId]) }}";

            const table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: ajaxUrl,
                columns: [{
                        data: "select",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "name",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "is_trial",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "views",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "duration",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "add",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "edit",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "delete",
                        orderable: false,
                        searchable: false
                    },
                ],
                columnDefs: [{
                        targets: 2,
                        render: function(data) {
                            return data;
                        }
                    },
                    {
                        targets: 4,
                        render: function(data) {
                            return data;
                        }
                    }
                ],
                rowCallback: function(row, data, index) {
                    // No additional processing needed
                }
            });

            // Đảm bảo các cột HTML được render đúng
            $.fn.dataTable.ext.errMode = 'none';

            window.lessonDataTable = table;
            table.on('draw', function() {
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

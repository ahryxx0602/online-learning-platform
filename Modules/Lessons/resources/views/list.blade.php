@extends('layouts.backend')

@section('content')
    <div class="d-flex mb-3">
        <a href="{{ route('admin.lessons.create', ['courseId' => $courseId]) }}" class="btn btn-primary mr-2">Thêm mới</a>
        <button
            type="button"
            class="btn btn-danger"
            id="bulk-delete-btn"
            data-url="{{ route('admin.lessons.deleteMultiple') }}"
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
                        <th>Thứ tự</th>
                        <th>Ngày tạo</th>
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
        $(document).ready(function () {
            const courseId = "{{ $courseId ?? 'null' }}";
            const ajaxUrl = "{{ route('admin.lessons.data', ['courseId' => $courseId]) }}";

            const table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: ajaxUrl,
                columns: [
                    { data: "select", orderable: false, searchable: false },
                    { data: "name" },
                    { data: "position" },
                    {
                        data: "views",
                        render: function (data) {
                            return data || 0;
                        }
                    },
                    {
                        data: "is_trial",
                        render: function (data) {
                            return data == 1
                                ? '<span class="badge badge-success">Có</span>'
                                : '<span class="badge badge-secondary">Không</span>';
                        }
                    },
                    {
                        data: "created_at",
                        render: function (data) {
                            if (!data) return '—';
                            let d = new Date(data.replace(' ', 'T'));
                            return d.toLocaleDateString('vi-VN') + ' ' + d.toLocaleTimeString('vi-VN');
                        }
                    },
                    { data: "edit", orderable: false, searchable: false },
                    { data: "delete", orderable: false, searchable: false },
                ]
            });

            window.lessonDataTable = table;

            // Reset checkbox after reload
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

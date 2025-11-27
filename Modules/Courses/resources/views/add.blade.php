@extends('layouts.backend')

@section('content')
    <form action="" method="post">
        @csrf
        <div class="row">

            {{-- Tên khóa học --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Tên khóa học</label>
                    <input
                        name="name"
                        id="name"
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Nhập tên khóa học..."
                        value="{{ old('name') }}"
                    >
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Slug --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Slug</label>
                    <input
                        name="slug"
                        id="slug"
                        type="text"
                        class="form-control @error('slug') is-invalid @enderror"
                        placeholder="Nhập slug..."
                        value="{{ old('slug') }}"
                    >
                    @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Giảng viên --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Giảng viên</label>
                    <select
                        name="teacher_id"
                        class="form-control @error('teacher_id') is-invalid @enderror"
                    >
                        <option value="0">-- Chọn giảng viên --</option>
                        @foreach($teachers ?? [] as $teacher)
                            <option value="{{ $teacher->id }}"
                                {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            {{-- Giá --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Giá</label>
                    <input
                        name="price"
                        type="number"
                        class="form-control @error('price') is-invalid @enderror"
                        placeholder="Nhập giá..."
                        value="{{ old('price') }}"
                    >
                    @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Giá khuyến mãi --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Giá khuyến mãi</label>
                    <input
                        name="sale_price"
                        type="number"
                        class="form-control @error('sale_price') is-invalid @enderror"
                        placeholder="Nhập giá khuyến mãi..."
                        value="{{ old('sale_price') }}"
                    >
                    @error('sale_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Mã khóa học --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Mã khóa học</label>
                    <input
                        name="code"
                        type="text"
                        class="form-control @error('code') is-invalid @enderror"
                        placeholder="Nhập mã..."
                        value="{{ old('code') }}"
                    >
                    @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Thời lượng --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Thời lượng (giờ)</label>
                    <input
                        name="durations"
                        type="number"
                        class="form-control @error('durations') is-invalid @enderror"
                        placeholder="VD: 30 giờ"
                        value="{{ old('durations') }}"
                    >
                    @error('durations')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Tài liệu --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Có tài liệu kèm theo?</label>
                    <select
                        name="is_document"
                        class="form-control @error('is_document') is-invalid @enderror"
                    >
                        <option value="1" {{ old('is_document') == 1 ? 'selected' : '' }}>Có</option>
                        <option value="0" {{ old('is_document') == 0 ? 'selected' : '' }}>Không</option>
                    </select>
                    @error('is_document')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Trạng thái --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Trạng thái</label>
                    <select
                        name="status"
                        class="form-control @error('status') is-invalid @enderror"
                    >
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Hiển thị</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Ẩn</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Hỗ trợ --}}
            <div class="col-12">
                <div class="mb-3">
                    <label for="">Hỗ trợ</label>
                    <textarea
                        name="supports"
                        class="form-control @error('supports') is-invalid @enderror"
                        placeholder="Ghi thông tin hỗ trợ..."
                        rows="3"
                    >{{ old('supports') }}</textarea>
                    @error('supports')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            {{-- Thumbnail — nằm dưới Trạng thái --}}
            <div class="col-12">
                <div class="mb-3">
                    <div class="row align-items-end">
                        <div class="col-7">
                            <label for="">Thumbnail</label>
                            <input
                                name="thumbnail"
                                id="thumbnail"
                                type="text"
                                class="form-control @error('thumbnail') is-invalid @enderror"
                                placeholder="Link ảnh..."
                                value="{{ old('thumbnail') }}"
                                oninput="previewImage()"
                            >
                            @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-2">
                            <button type="button" class="btn btn-primary">
                                <i class="fas fa-image"></i> Chọn ảnh
                            </button>
                        </div>

                        <div class="col-3 mt-2">
                            <img id="preview"
                                 src="https://fastly.picsum.photos/id/237/200/300.jpg?hmac=TmmQSbShHz9CdQm0NkEjx1Dyh_Y984R9LpNrpvH2D_U"
                                 class="img-thumbnail">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Chi tiết khóa học — đặt dưới Thumbnail --}}
            <div class="col-12">
                <div class="mb-3">
                    <label for="">Chi tiết khóa học</label>
                    <textarea
                        name="detail"
                        class="form-control @error('detail') is-invalid @enderror"
                        placeholder="Nhập mô tả chi tiết..."
                        rows="4"
                    >{{ old('detail') }}</textarea>
                    @error('detail')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Buttons --}}
            <div class="col-12">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Lưu lại</button>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </div>
    </form>
    <!-- Modal xem ảnh -->
    <div class="modal fade" id="previewModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content p-3">
                <img id="modalImage" src="" style="width: 100%; border-radius: 6px;">
            </div>
        </div>
    </div>
@endsection

{{-- JS Preview --}}
@section('stylesheet')
    <style>
        /* Style cho preview */
        #preview {
            max-height: 150px;         /* GIỚI HẠN CHIỀU CAO NHỎ */
            width: auto;              /* ĐỂ ẢNH TỰ GIỮ TỈ LỆ */
            object-fit: contain;      /* KHÔNG BAO GIỜ CROP */
            border-radius: 4px;
            border: 1px solid #dcdcdc;
            background: #f1f1f1;
            padding: 2px;
        }


        #preview:hover {
            transform: scale(1.03);
            box-shadow: 0 0 8px rgba(0,0,0,0.15);
        }

        img{
            max-width: 100%;
            height: auto;
        }

    </style>
@endsection
@push('scripts')
<script>
    function previewImage() {
        let url = document.getElementById('thumbnail').value.trim();
        let img = document.getElementById('preview');

        // Nếu không nhập gì → ảnh mặc định
        if (url === "") {
            img.src = "https://via.placeholder.com/200x150?text=Preview";
            return;
        }

        // Kiểm tra link ảnh hợp lệ
        let tester = new Image();
        tester.onload = () => img.src = url;
        tester.onerror = () => img.src = "https://via.placeholder.com/200x150?text=Invalid+URL";
        tester.src = url;
    }
    document.getElementById('preview').addEventListener('click', function () {
        let src = this.src;
        document.getElementById('modalImage').src = src;
        $('#previewModal').modal('show');
    });
</script>
@endpush

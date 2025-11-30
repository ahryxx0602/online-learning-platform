@extends('layouts.backend')

@section('content')
    <form action="{{ route('admin.courses.store') }}" method="post">
        @csrf
        <div class="row">

            {{-- Tên khóa học --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Tên khóa học</label>
                    <input name="name" id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        placeholder="Nhập tên khóa học..." value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Slug --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Slug</label>
                    <input name="slug" id="slug" type="text"
                        class="form-control @error('slug') is-invalid @enderror" placeholder="Nhập slug..."
                        value="{{ old('slug') }}">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Giảng viên --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Giảng viên</label>
                    <select name="teacher_id" class="form-control @error('teacher_id') is-invalid @enderror">
                        <option value="0">-- Chọn giảng viên --</option>
                        @if($teachers)
                            @foreach ($teachers ?? [] as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        @endif
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
                    <input name="price" type="number" class="form-control @error('price') is-invalid @enderror"
                        placeholder="Nhập giá..." value="{{ old('price') }}">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Giá khuyến mãi --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Giá khuyến mãi</label>
                    <input name="sale_price" type="number" class="form-control @error('sale_price') is-invalid @enderror"
                        placeholder="Nhập giá khuyến mãi..." value="{{ old('sale_price') }}">
                    @error('sale_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Mã khóa học --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Mã khóa học</label>
                    <input name="code" type="text" class="form-control @error('code') is-invalid @enderror"
                        placeholder="Nhập mã..." value="{{ old('code') }}">
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            {{-- Tài liệu --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Có tài liệu kèm theo?</label>
                    <select name="is_document" class="form-control @error('is_document') is-invalid @enderror">
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
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Đã ra mắt</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Chưa ra mắt</option>
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
                    <textarea name="supports" class="form-control @error('supports') is-invalid @enderror"
                        placeholder="Ghi thông tin hỗ trợ..." rows="3">{{ old('supports') }}</textarea>
                    @error('supports')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            {{-- Thumbnail — nằm dưới Trạng thái --}}
            <div class="col-12">
                <div class="mb-3">
                    <div class="row {{ $errors->has('thumbnail') ? 'align-items-center' : 'align-items-end' }}">
                        <div class="col-7">
                            <label for="">Thumbnail</label>
                            <input name="thumbnail" id="thumbnail" type="text"
                                class="form-control @error('thumbnail') is-invalid @enderror" placeholder="Link ảnh..."
                                value="{{ old('thumbnail') }}">
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-2">
                            <button id="lfm" data-input="thumbnail" data-preview="holder" type="button"
                                class="btn btn-primary">
                                <i class="fas fa-image"></i> Chọn ảnh
                            </button>
                        </div>

                        <div class="col-3 mt-2">
                            <div id="holder">
                                @if (old('thumbnail'))
                                    <img style="height: 5rem;" src="{{ old('thumbnail') }}" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Chi tiết khóa học — đặt dưới Thumbnail --}}
            <div class="col-12">
                <div class="mb-3">
                    <label for="">Chi tiết khóa học</label>
                    <textarea name="detail" id="detail" class="form-control ckeditor @error('detail') is-invalid @enderror"
                        placeholder="Nhập mô tả chi tiết..." rows="4">{{ old('detail', $course->detail ?? '') }}</textarea>
                    @error('detail')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label for="">Chuyên mục</label>
                    <div class="list-categories">
                        {!! getCategoriesCheckbox($categories, old('categories', [])) !!}
                    </div>
                    @error('categories')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
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
@endsection

{{-- JS Preview --}}
@section('stylesheet')
    <style>
        /* Khung holder hiển thị ảnh sau khi chọn */
        #holder {
            width: 120px;
            height: 90px;
            border: 1px solid #dcdcdc;
            background: #fafafa;
            border-radius: 6px;
            padding: 4px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: 0.2s;
        }

        /* Hover đẹp */
        #holder:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            transform: scale(1.03);
        }

        .list-categories {
            max-height: 250px;
            overflow: auto;
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
    </script>
@endpush

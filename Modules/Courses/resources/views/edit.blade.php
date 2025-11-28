@extends('layouts.backend')

@section('content')

    @if(session('msg'))
        <div class="alert alert-success">
            {{ session('msg') }}
        </div>
    @endif

    <form action="{{ route('admin.courses.update', $course->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="row">

            {{-- Tên khóa học --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Tên khóa học</label>
                    <input
                        name="name"
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $course->name) }}"
                        placeholder="Nhập tên khóa học..."
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
                        type="text"
                        class="form-control @error('slug') is-invalid @enderror"
                        value="{{ old('slug', $course->slug) }}"
                        placeholder="Nhập slug..."
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
                        <option value="1">Phan Văn Thành</option>
{{--                        @foreach($teachers as $teacher)--}}
{{--                            <option value="{{ $teacher->id }}"--}}
{{--                                {{ old('teacher_id', $course->teacher_id) == $teacher->id ? 'selected' : '' }}>--}}
{{--                                {{ $teacher->name }}--}}
{{--                            </option>--}}
{{--                        @endforeach--}}
                        <select name="teacher_id" class="form-control">
                            <option value="0">-- Chưa có giảng viên --</option>
                        </select>
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
                        value="{{ old('price', $course->price) }}"
                        placeholder="Nhập giá..."
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
                        value="{{ old('sale_price', $course->sale_price) }}"
                        placeholder="Nhập giá khuyến mãi..."
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
                        value="{{ old('code', $course->code) }}"
                        placeholder="Nhập mã..."
                    >
                    @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Tài liệu --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Có tài liệu?</label>
                    <select
                        name="is_document"
                        class="form-control @error('is_document') is-invalid @enderror"
                    >
                        <option value="1" {{ old('is_document', $course->is_document) == 1 ? 'selected' : '' }}>Có</option>
                        <option value="0" {{ old('is_document', $course->is_document) == 0 ? 'selected' : '' }}>Không</option>
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
                        <option value="1" {{ old('status', $course->status) == 1 ? 'selected' : '' }}>Đã ra mắt</option>
                        <option value="0" {{ old('status', $course->status) == 0 ? 'selected' : '' }}>Chưa ra mắt</option>
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
                        rows="3"
                        placeholder="Nhập hỗ trợ..."
                    >{{ old('supports', $course->supports) }}</textarea>
                    @error('supports')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Thumbnail --}}
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
                                value="{{ old('thumbnail', $course->thumbnail) }}"
                                placeholder="Link ảnh..."
                                oninput="previewImage()"
                            >
                            @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-2">
                            <button id="lfm" data-input="thumbnail" data-preview="holder" type="button" class="btn btn-primary">
                                <i class="fas fa-image"></i> Chọn ảnh
                            </button>
                        </div>

                        <div class="col-3 mt-2">
                            <div id="holder">
                                @if(old('thumbnail', $course->thumbnail))
                                    <img style="height: 5rem;" src="{{ old('thumbnail', $course->thumbnail) }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Chi tiết --}}
            <div class="col-12">
                <div class="mb-3">
                    <label for="">Chi tiết khóa học</label>
                    <textarea
                        name="detail"
                        id="detail"
                        class="form-control ckeditor @error('detail') is-invalid @enderror"
                        rows="4"
                    >{{ old('detail', $course->detail) }}</textarea>
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

@endsection

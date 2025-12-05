@extends('layouts.backend')
@section('content')
    <form action="" method="post">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="name">Tên bài giảng</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Nhập tên bài giảng..."
                        value="{{ old('name') }}"
                    >
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-6">
                <div class="mb-3">
                    <label for="slug">Slug</label>
                    <input
                        id="slug"
                        name="slug"
                        type="text"
                        class="form-control @error('slug') is-invalid @enderror"
                        placeholder="Slug..."
                        value="{{ old('slug') }}"
                    >
                    @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-4">
                <div class="mb-3">
                    <label for="parent_id">Nhóm bài giảng</label>
                    <select name="parent_id" class="form-control">
                        <option value="0">Trống</option>
                    </select>
                    @error('parent_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-4">
                <div class="mb-3">
                    <label for="is_trial">Học thử</label>
                    <select name="is_trial" class="form-control">
                        <option value="0">Không</option>
                        <option value="1">Có</option>
                    </select>
                    @error('is_trial')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-4">
                <div class="mb-3">
                    <label for="position">Thứ tự hiển thị</label>
                    <input
                        id="position"
                        name="position"
                        type="number"
                        class="form-control @error('position') is-invalid @enderror"
                        placeholder="Ví dụ: 1"
                        value="{{ old('position', 0) }}"
                    >
                    @error('position')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-4">
                <div class="mb-3">
                    <label for="video_id">Video</label>
                    <div class="input-group">
                        <input type="" class="form-control" placeholder="Video bài giảng" disabled/>
                        <button class="btn btn-success">Chọn</button>
                    </div>
                    @error('video_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-4">
                <div class="mb-3">
                    <label for="document_id">Tài liệu</label>
                    <div class="input-group">
                        <input type="" class="form-control" placeholder="Tài liệu bài giảng" disabled/>
                        <button class="btn btn-success">Chọn</button>
                    </div>
                    @error('document_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="col-12">
                <div class="mb-3">
                    <label for="description">Mô tả</label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        class="ckeditor @error('description') is-invalid @enderror"
                        placeholder="Nhập mô tả ngắn..."
                    >{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Lưu lại</button>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </div>
    </form>
@endsection


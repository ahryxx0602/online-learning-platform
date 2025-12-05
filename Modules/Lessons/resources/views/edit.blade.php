@extends('layouts.backend')
@section('content')

    @if(session('msg'))
        <div class="alert alert-success">
            {{session('msg')}}
        </div>
    @endif

    <form action="" method="post">
        @csrf
        @method('PUT')
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
                        value="{{ old('name') ?? ($lesson->name ?? '') }}"
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
                        placeholder="nhap-ten-bai-giang"
                        value="{{ old('slug') ?? ($lesson->slug ?? '') }}"
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
                        <option value="0" {{ old('is_trial', $lesson->is_trial ?? 0) == 0 ? 'selected' : '' }}>Không</option>
                        <option value="1" {{ old('is_trial', $lesson->is_trial ?? 0) == 1 ? 'selected' : '' }}>Có</option>
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
                        value="{{ old('position', $lesson->position ?? 0) }}"
                    >
                    @error('position')
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
                    >{{ old('description', $lesson->description ?? '') }}</textarea>
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


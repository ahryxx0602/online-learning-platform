@extends('layouts.backend')

@section('content')

    @if(session('msg'))
        <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    <form action="" method="post">
        @csrf
        <div class="row">

            {{-- Tên --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Tên giảng viên</label>
                    <input
                        name="name"
                        id="name"
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Nhập tên..."
                        value="{{ old('name') }}"
                    >
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                    @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Kinh nghiệm --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Số năm kinh nghiệm</label>
                    <input
                        name="exp"
                        type="number"
                        step="0.1"
                        class="form-control @error('exp') is-invalid @enderror"
                        placeholder="VD: 3.5"
                        value="{{ old('exp') }}"
                    >
                    @error('exp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Ảnh đại diện (Thumbnail) --}}
            <div class="col-12">
                <div class="mb-3">
                    <div class="row align-items-end">
                        <div class="col-7">
                            <label for="">Ảnh đại diện</label>
                            <input
                                name="image"
                                id="image"
                                type="text"
                                class="form-control @error('image') is-invalid @enderror"
                                placeholder="Link ảnh..."
                                value="{{ old('image') }}"
                            >
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-2">
                            <button id="lfm" data-input="image" data-preview="holder"
                                    type="button" class="btn btn-primary">
                                <i class="fas fa-image"></i> Chọn ảnh
                            </button>
                        </div>

                        <div class="col-3 mt-2">
                            <div id="holder">
                                @if (old('image'))
                                    <img src="{{ old('image') }}" style="height: 5rem;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mô tả --}}
            <div class="col-12">
                <div class="mb-3">
                    <label for="">Mô tả</label>
                    <textarea
                        name="description"
                        rows="4"
                        class="form-control @error('description') is-invalid @enderror"
                    >{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Lưu lại</button>
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">Hủy</a>
            </div>

        </div>
    </form>
@endsection

{{-- CSS của holder --}}
@section('stylesheet')
    <style>
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

        #holder:hover {
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
            transform: scale(1.03);
        }
    </style>
@endsection


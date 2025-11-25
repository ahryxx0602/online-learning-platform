@extends('layouts.backend')
@section('content')

    <form action="{{ route('admin.categories.store') }}" method="post">
        @csrf

        <div class="row">

            {{-- TÊN --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="name">Tên</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Nhập tên..."
                        value="{{ old('name') }}"
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- SLUG --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="slug">Slug</label>
                    <input
                        id="slug"
                        name="slug"
                        type="text"
                        class="form-control @error('slug') is-invalid @enderror"
                        placeholder="Slug tự sinh..."
                        value="{{ old('slug') }}"
                    >
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- CHA --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="parent_id">Danh mục cha</label>
                    <select
                        id="parent_id"
                        name="parent_id"
                        class="form-control @error('parent_id') is-invalid @enderror"
                    >
                        <option value="0" {{ old('parent_id', 0) == 0 ? 'selected' : '' }}>Không</option>
                        @isset($parents)
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                    @error('parent_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary">Lưu lại</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy</a>
            </div>

        </div>
    </form>

@endsection

@push('scripts')
    <script src="{{ asset('backend/js/scripts.js') }}"></script>
@endpush
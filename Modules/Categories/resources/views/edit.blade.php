@extends('layouts.backend')
@section('content')

    @if(session('msg'))
        <div class="alert alert-success">
            {{session('msg')}}
        </div>
    @endif

    <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Tên</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Nhập tên..."
                        value="{{ old('name', $category->name) }}"
                    >
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Slug</label>
                    <input
                    id="slug"
                    name="slug"
                    type="text"
                    class="form-control @error('slug') is-invalid @enderror"
                    placeholder="Slug..."
                    value="{{ old('slug', $category->slug) }}"
                >
                    @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Cha</label>
                    <select name="parent_id" id="" class="form-control @error('parent_id') is-invalid @enderror">
                        <option value="0" {{ old('parent_id', $category->parent_id ?? 0) == 0 ? 'selected' : '' }}>Không</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id ?? 0) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-12 d-flex mt-3">
                <button type="submit" class="btn btn-primary mr-2">Lưu lại</button>
                <a href="{{route('admin.categories.index')}}" class="btn btn-secondary">Hủy</a>
            </div>
        </div>
        @method('PUT')
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('backend/js/scripts.js') }}"></script>
@endpush
@extends('layouts.backend')
@section('content')
@if(session('msg'))
    <div class="alert alert-success">
        {{ session('msg') }}
    </div>
@endif
    <form action="" method="post">
        @csrf
        <div id="sortable-list" class="list-group mb-3">
            @foreach ($modules as $module)
                <div id="item-{{$module->id}}" data-id="{{$module->id}}" class="list-group-item title">
                    {{$module->name}}
                    <input type="hidden" name="lesson[]" value="{{$module->id}}"/>
                </div>
                @if ($module->children)
                    @php
                        $lessons = $module->children()->orderBy('position', 'asc')->get();
                    @endphp
                    @foreach ($lessons as $lesson)
                    <div id="item-{{$lesson->id}}" data-id="{{$lesson->id}}" class="list-group-item children">
                        {{$lesson->name}}
                        <input type="hidden" name="lesson[]" value="{{$lesson->id}}"/>
                    </div> 
                    @endforeach
                @endif
                @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Lưu lại</button>
        <a href="{{ route('admin.lessons.index', ['courseId' => $courseId]) }}" class="btn btn-secondary">Hủy</a>
    </form>
@endsection
@section('stylesheet')
    <style>
        .ghost {
            opacity: 0.4;
        }
        .list-group {
            margin-bottom: 20px;
        }
        .children {
            padding-left: 50px;
        }
        .title {
            font-weight: bold;
        }
    </style>
@endsection
@push('scripts') {{-- Dùng push sẽ tốt hơn cho script --}}
<script>
    $('#sortable-list').sortable({
        group: 'list',
        animation: 200,
        ghostClass: 'ghost',
        onSort: () => {
            console.log('Đã sắp xếp xong!');
        },
    });
</script>
@endpush


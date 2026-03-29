@extends('layouts.client')

@section('stylesheets')
<style>
    .watch-layout {
        display: flex;
        gap: 0;
        min-height: calc(100vh - 70px);
    }
    .watch-sidebar {
        width: 340px;
        flex-shrink: 0;
        background: #1c1c1c;
        color: #ccc;
        overflow-y: auto;
        max-height: calc(100vh - 70px);
        position: sticky;
        top: 70px;
    }
    .watch-sidebar h3 {
        font-size: 15px;
        padding: 16px;
        border-bottom: 1px solid #333;
        color: #fff;
        margin: 0;
    }
    .sidebar-module-title {
        background: #2a2a2a;
        padding: 12px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
        border-bottom: 1px solid #333;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .sidebar-lesson-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 10px 16px 10px 24px;
        border-bottom: 1px solid #2a2a2a;
        font-size: 13px;
        color: #aaa;
        text-decoration: none;
        transition: background .15s;
    }
    .sidebar-lesson-item:hover {
        background: #2a2a2a;
        color: #fff;
    }
    .sidebar-lesson-item.active {
        background: #2d4a2d;
        color: #5cb85c;
        font-weight: 600;
    }
    .sidebar-lesson-item .lesson-name {
        flex: 1;
        line-height: 1.4;
    }
    .sidebar-lesson-item .lesson-duration {
        font-size: 11px;
        color: #666;
        white-space: nowrap;
        margin-top: 2px;
    }
    .watch-main {
        flex: 1;
        background: #000;
        min-width: 0;
    }
    .video-wrapper {
        background: #000;
        width: 100%;
    }
    .watch-info {
        background: #fff;
        padding: 24px 32px;
    }
    .watch-info h1 {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .watch-info .meta {
        font-size: 13px;
        color: #888;
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }
    .watch-info .lesson-desc {
        margin-top: 16px;
        font-size: 14px;
        color: #444;
        line-height: 1.7;
    }
    @media (max-width: 991px) {
        .watch-layout {
            flex-direction: column;
        }
        .watch-sidebar {
            width: 100%;
            max-height: 350px;
            position: static;
        }
    }
</style>
@endsection

@section('content')
<div class="watch-layout">

    {{-- Sidebar curriculum --}}
    <aside class="watch-sidebar">
        <h3><i class="fa-solid fa-list me-2"></i>Nội dung khóa học</h3>
        @php $sidebarIndex = 0; @endphp
        @foreach ($modules as $module)
            <div class="sidebar-module-title">
                <span>{{ $module->name }}</span>
            </div>
            @foreach (getLessonsByPosition($course, $module->id) as $item)
                @php $sidebarIndex++ @endphp
                <a href="{{ route('lessons.detail', $item->slug) }}"
                   class="sidebar-lesson-item {{ $item->id === $lesson->id ? 'active' : '' }}">
                    <i class="fa-brands fa-youtube mt-1" style="font-size:13px;flex-shrink:0;"></i>
                    <div>
                        <div class="lesson-name">Bài {{ $sidebarIndex }}: {{ $item->name }}</div>
                        <div class="lesson-duration"><i class="fa-regular fa-clock me-1"></i>{{ getTime($item->duration) }}</div>
                    </div>
                </a>
            @endforeach
        @endforeach
    </aside>

    {{-- Khu vực xem video --}}
    <div class="watch-main">
        <div class="video-wrapper">
            @if ($lesson->video)
                @php
                    $streamUrl = route('courses.stream.lesson', $lesson->id);
                @endphp
                <video id="watch-player"
                       class="video-js vjs-default-skin vjs-big-play-centered"
                       controls
                       autoplay
                       style="width:100%;min-height:360px;">
                    <source src="{{ $streamUrl }}" type="video/mp4">
                </video>
            @else
                <div class="d-flex justify-content-center align-items-center" style="min-height:360px;background:#111;">
                    <p class="text-muted">Video đang được cập nhật.</p>
                </div>
            @endif
        </div>

        <div class="watch-info">
            <h1>{{ $lesson->name }}</h1>
            <div class="meta">
                <span><i class="fa-solid fa-book me-1"></i>{{ $course->name }}</span>
                <span><i class="fa-regular fa-clock me-1"></i>{{ getTime($lesson->duration) }}</span>
                <span><i class="fa-solid fa-eye me-1"></i>{{ number_format($lesson->views) }} lượt xem</span>
            </div>
            @if ($lesson->description)
                <div class="lesson-desc">{{ $lesson->description }}</div>
            @endif

            @if ($lesson->document)
                <div class="mt-4">
                    <a href="{{ asset($lesson->document->url) }}" download
                       class="btn btn-outline-primary btn-sm">
                        <i class="fa-solid fa-download me-1"></i>Tải tài liệu bài giảng
                        @if ($lesson->document->name)
                            &ndash; {{ $lesson->document->name }}
                        @endif
                    </a>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

@section('scripts')
@if ($lesson->video)
<script>
    videojs('watch-player', { fluid: true, responsive: true });
</script>
@endif
@endsection

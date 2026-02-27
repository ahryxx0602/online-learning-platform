@extends('layouts.client')
@section('content')
@include('parts.clients.page_title')
<section class="course-detal">
    <div class="container">
        <div class="row relative">
            <div class="col-12 col-lg-9">
                <div class="submenu">
                    <ul>
                        <li>
                            <a href="#information">
                                <i class="fa-solid fa-file"></i> Thông tin chung
                            </a>
                        </li>
                        <li>
                            <a href="#curriculum">
                                <i class="fa-solid fa-book"></i>
                                Giáo trình
                            </a>
                        </li>
                        <li>
                            <a href="#author">
                                <i class="fa-solid fa-user"></i>
                                Giảng viên
                            </a>
                        </li>
                        <li>
                            <a href="#evaluate">
                                <i class="fa-solid fa-comment"></i>
                                Đánh giá
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="course-descreption mb-4" id="information">
                    <div class="course-content">
                        {!! $course->detail !!}
                    </div>
                </div>
                <div class="accordion" id="curriculum">
                    <div class="accordion-top">
                        <p>
                            <i class="fa-solid fa-book me-1"></i>
                            Gồm: {{getLessonCount($course)->module}} phần - {{getLessonCount($course)->lessons}} bài giảng
                        </p>
                        <p>
                            <i class="fa-solid fa-clock me-1"></i>
                            Thời lượng {{ getMinute($course->durations)}}
                        </p>
                    </div>
                    @include('courses::clients.lesson')
                </div>
                @if ( $course->teacher )
                <div class="course-video mb-3" id="author">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img class="rounded-circle"
                            style="width: 100px; height: 100px; object-fit: cover;" 
                            src="{{ $course->teacher->image }}" alt="{{ $course->teacher->name }}">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p>Giảng viên</p>
                            <h4 class="mt-2"><a href="/giang-vien/{{ $course->teacher->slug }}">{{ $course->teacher->name }}</a></h4>
                        </div>
                    </div>
                    <p class="course-content-infor mt-3">
                        {!! $course->teacher->description !!}
                    </p>
                </div>
                @endif
                <div class="course-video mb-3" id="evaluate">
                    <h2 class="fs-4 mb-3">Học viên đánh giá</h2>
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                            <img class="rounded-circle"
                            style="width: 100px; height: 100px; object-fit: cover;" 
                            src="https://picsum.photos/id/237/200/300" alt="Generic placeholder image"">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p>Đánh giá</p>
                            <h4 class="mt-2">4.5</h4>
                            <p>5 đánh giá</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="course-profile mb-4">
                    <div class="img">
                        <img src="{{ $course->thumbnail }}" alt="" />
                    </div>
                    <div class="group-text">
                        <p class="price">
                            <i class="fa-solid fa-tag"></i>
                            @if($course->sale_price)
                                <span class="sale">{{money($course->price)}}</span>
                                <span>{{money($course->sale_price)}}</span>
                            @else
                                <span>{{money($course->sale_price)}}</span>
                            @endif
                        </p>
                        <p class="bookmark">
                            <i class="fa-solid fa-bookmark"></i>
                            Mã Khóa Học: LU-001
                        </p>
                        {{-- <p class="chart">
                            <i class="fa-solid fa-chart-simple"></i>
                            Cấp độ: Thực chiến
                        </p> --}}
                        <p class="techer">
                            <i class="fa-solid fa-user"></i>
                            Giảng viên: {{ $course->teacher->name . ' - '. $course->teacher->exp}} năm kinh nghiệm
                        </p>
                        <p class="clock">
                            <i class="fa-solid fa-clock"></i>
                            Thời lượng: {{ getHour($course->durations)}} học
                        </p>

                        <p class="support">
                            <i class="fa-brands fa-hire-a-helper"></i>
                            Hỗ trợ: {{ $course->supports }}
                        </p>
                        <p class="document">
                            <i class="fa-regular fa-file"></i>
                            Tài liệu đính kèm: {{ $course->isDocument ? 'Có' : 'Không' }}
                        </p>
                        <button class="payment">đặt mua khóa học</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
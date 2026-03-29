<?php

namespace Modules\Courses\app\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Courses\Repositories\CoursesRepositoryInterface;
use Modules\Lessons\Repositories\LessonsRepositoryInterface;

class CoursesController extends Controller
{
    protected $coursesRepository;

    protected $lessonsRepository;

    public function __construct(
        CoursesRepositoryInterface $coursesRepository,
        LessonsRepositoryInterface $lessonsRepository,
    )
    {
        $this->coursesRepository = $coursesRepository;
        $this->lessonsRepository = $lessonsRepository;
    }


    public function index() {
        $pageTitle = 'Khóa học';
        $pageName = 'Khóa học';
        $courses = $this->coursesRepository->getCourses(config('paginate.limit'));
        return view('courses::clients.index', compact('pageTitle', 'pageName', 'courses'));
    }
    
    public function detail($slug) {
        $course = $this->coursesRepository->getCourseActive($slug);
        if(!$course){
            abort(404);
        }
        $index = 0;
        $pageTitle = $course->name;
        $pageName = $course->name;
        return view('courses::clients.detail', compact('pageTitle', 'pageName', 'course', 'index')); 
    }

    public function getTrialVideo($lesonId = 0){
        $lesson = $this->lessonsRepository->find($lesonId);
        if(!$lesonId){
            return ['success'=> false];
        }
        $lesson->load('video');
        return [
            'success'=> true,
            'data' => $lesson
        ];
    }

    public function streamTrialVideo(Request $request, $lessonId)
    {
        $lesson = $this->lessonsRepository->find($lessonId);
        if (!$lesson || !$lesson->is_trial) {
            abort(403);
        }
        $lesson->load('video');
        return $this->streamVideoResponse($request, $lesson);
    }

    public function streamVideo(Request $request, $lessonId)
    {
        $lesson = $this->lessonsRepository->find($lessonId);
        if (!$lesson) {
            abort(404);
        }
        $lesson->load('video');
        return $this->streamVideoResponse($request, $lesson);
    }

    private function streamVideoResponse(Request $request, $lesson)
    {
        if (!$lesson->video) {
            abort(404);
        }

        $relativePath = ltrim(parse_url($lesson->video->url, PHP_URL_PATH), '/');
        $relativePath = preg_replace('#^storage/#', '', $relativePath);

        if (!Storage::disk('public')->exists($relativePath)) {
            abort(404);
        }

        $fullPath   = Storage::disk('public')->path($relativePath);
        $fileSize   = filesize($fullPath);
        $mimeType   = mime_content_type($fullPath) ?: 'video/mp4';

        $start      = 0;
        $end        = $fileSize - 1;
        $statusCode = 200;
        $headers    = [
            'Content-Type'  => $mimeType,
            'Accept-Ranges' => 'bytes',
            'Content-Length'=> $fileSize,
        ];

        if ($request->hasHeader('Range')) {
            preg_match('/bytes=(\d+)-(\d*)/', $request->header('Range'), $matches);
            $start = (int) $matches[1];
            $end   = isset($matches[2]) && $matches[2] !== '' ? (int) $matches[2] : $fileSize - 1;

            $headers['Content-Range']   = "bytes {$start}-{$end}/{$fileSize}";
            $headers['Content-Length']  = $end - $start + 1;
            $statusCode = 206;
        }

        $chunkSize = 1024 * 1024;
        $stream    = fopen($fullPath, 'rb');
        fseek($stream, $start);

        return response()->stream(function () use ($stream, $start, $end, $chunkSize) {
            $remaining = $end - $start + 1;
            while (!feof($stream) && $remaining > 0) {
                $read = min($chunkSize, $remaining);
                echo fread($stream, $read);
                $remaining -= $read;
                flush();
            }
            fclose($stream);
        }, $statusCode, $headers);
    }
}

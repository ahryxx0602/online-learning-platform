<?php

namespace Modules\Courses\app\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Modules\Courses\Repositories\CoursesRepositoryInterface;
use Modules\Lessons\Repositories\LessonsRepository;
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
}

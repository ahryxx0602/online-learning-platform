<?php

namespace Modules\Courses\app\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Modules\Courses\Repositories\CoursesRepositoryInterface;

class CoursesController extends Controller
{
    protected $coursesRepository;

    protected $teachersRepository;

    public function __construct(
        CoursesRepositoryInterface $coursesRepository,

    )
    {
        $this->coursesRepository = $coursesRepository;
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
}

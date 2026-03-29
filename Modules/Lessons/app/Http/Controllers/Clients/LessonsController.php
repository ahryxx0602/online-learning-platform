<?php

namespace Modules\Lessons\app\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Modules\Courses\Repositories\CoursesRepositoryInterface;
use Modules\Lessons\Repositories\LessonsRepositoryInterface;

class LessonsController extends Controller
{
    protected $lessonsRepository;
    protected $coursesRepository;

    public function __construct(
        LessonsRepositoryInterface $lessonsRepository,
        CoursesRepositoryInterface $coursesRepository,
    ) {
        $this->lessonsRepository = $lessonsRepository;
        $this->coursesRepository = $coursesRepository;
    }

    public function detail($slug)
    {
        $lesson = $this->lessonsRepository->findBySlug($slug);
        if (!$lesson || !$lesson->parent_id) {
            abort(404);
        }

        $lesson->load(['video', 'document', 'course']);
        $course = $lesson->course;
        $modules = $this->lessonsRepository->getModuleByPosition($course);

        $pageTitle = $lesson->name;
        $pageName  = $lesson->name;

        return view('lessons::clients.watch', compact('pageTitle', 'pageName', 'lesson', 'course', 'modules'));
    }
}

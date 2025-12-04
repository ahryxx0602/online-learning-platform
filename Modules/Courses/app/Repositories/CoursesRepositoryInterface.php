<?php

namespace Modules\Courses\Repositories;

use App\Repositories\RepositoryInterface;

interface CoursesRepositoryInterface extends RepositoryInterface
{
    public function getAllCourses();

    public function deleteMultiple(array $ids);

    public function createCourseCategories($course, $data = []);

    public function updateCourseCategories($course, $data = []);

    public function getRelatedCategories($course);
}

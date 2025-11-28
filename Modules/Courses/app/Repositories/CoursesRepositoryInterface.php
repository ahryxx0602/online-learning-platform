<?php

namespace Modules\Courses\Repositories;

interface CoursesRepositoryInterface
{
    public function getAllCourses();



    public function deleteMultiple(array $ids);

    public function createCourseCategories($course, $data=[]);
}

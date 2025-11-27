<?php

namespace Modules\Courses\Repositories;

interface CoursesRepositoryInterface
{
    public function getAllCourses();

    public function getCourse($limit);

    public function deleteMultiple(array $ids);
}

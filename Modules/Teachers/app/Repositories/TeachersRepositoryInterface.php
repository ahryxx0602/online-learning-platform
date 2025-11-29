<?php

namespace Modules\Teachers\Repositories;

interface TeachersRepositoryInterface
{
    public function getAllTeachers();
    public function deleteMultiple(array $ids);
}

<?php

namespace Modules\Teachers\Repositories;

use App\Repositories\RepositoryInterface;

interface TeachersRepositoryInterface extends RepositoryInterface
{
    public function getAllTeachers();

    public function deleteMultiple(array $ids);
}

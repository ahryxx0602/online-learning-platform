<?php

namespace Modules\Teachers\Repositories;

use App\Repositories\BaseRepository;
use Modules\Teachers\Models\Teacher;

class TeachersRepository extends BaseRepository implements TeachersRepositoryInterface
{
    public function getModel()
    {
        return Teacher::class;
    }

    public function getAllTeachers()
    {
        return $this->model
            ->select(['id', 'name', 'slug', 'description', 'exp', 'image', 'created_at'])
            ->latest()
            ->get();
    }

    public function deleteMultiple(array $ids): int
    {
        return $this->model->whereIn('id', $ids)->delete();
    }
}

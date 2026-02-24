<?php

namespace Modules\Students\Repositories;

use App\Repositories\BaseRepository;
use Modules\Students\Models\Students;

class StudentsRepository extends BaseRepository implements StudentsRepositoryInterface
{
    public function getModel()
    {
        return Students::class;
    }
}

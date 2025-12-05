<?php

namespace Modules\Videos\Repositories;

use App\Repositories\RepositoryInterface;

interface VideosRepositoryInterface extends RepositoryInterface
{
    // Define methods here
    public function createVideo($data);
}

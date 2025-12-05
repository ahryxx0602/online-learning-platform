<?php

namespace Modules\Videos\Repositories;

use App\Repositories\BaseRepository;
use Modules\Videos\Models\Video;    

class VideosRepository extends BaseRepository implements VideosRepositoryInterface
{
    public function getModel()
    {
        return Video::class;
    }
    public function createVideo($data){
        return $this->model->firstOrCreate($data);
    }
}

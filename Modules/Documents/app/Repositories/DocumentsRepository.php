<?php

namespace Modules\Documents\Repositories;

use App\Repositories\BaseRepository;
use Modules\Documents\Models\Document;

class DocumentsRepository extends BaseRepository implements DocumentsRepositoryInterface
{
    public function getModel()
    {
        return Document::class;
    }
    public function createDocument($data, $url){
        return $this->model->firstOrCreate(['url' => $url], $data);
    }
}

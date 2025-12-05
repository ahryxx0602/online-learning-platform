<?php

namespace Modules\Documents\Repositories;

use App\Repositories\RepositoryInterface;

interface DocumentsRepositoryInterface extends RepositoryInterface
{
    // Define methods here
    public function createDocument($data);
}

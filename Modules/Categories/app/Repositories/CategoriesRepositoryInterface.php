<?php

namespace Modules\Categories\Repositories;

use App\Repositories\RepositoryInterface;

interface CategoriesRepositoryInterface extends RepositoryInterface
{
    public function getCategories();

    public function getAllCategories();

    public function deleteMultiple(array $ids);
}

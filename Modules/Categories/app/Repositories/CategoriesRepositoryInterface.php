<?php

namespace Modules\Categories\Repositories;

interface CategoriesRepositoryInterface
{

    public function getCategories();

    public function getAllCategories();

    public function deleteMultiple(array $ids);
}

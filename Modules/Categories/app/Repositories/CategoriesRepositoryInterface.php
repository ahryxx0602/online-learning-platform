<?php

namespace Modules\Categories\Repositories;

interface CategoriesRepositoryInterface
{
    public function getCategories($limit);

    public function getAllForDataTable();

    public function getParentOptions($excludeId = null);

    public function deleteMultiple(array $ids);
}

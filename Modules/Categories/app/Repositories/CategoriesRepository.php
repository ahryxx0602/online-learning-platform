<?php

namespace Modules\Categories\Repositories;

use App\Repositories\BaseRepository;
use Modules\Categories\Models\Category;

class CategoriesRepository extends BaseRepository implements CategoriesRepositoryInterface
{
    public function getModel()
    {
        return Category::class;
    }


    public function getCategories()
    {
        return $this->model->with(['subCategories'])
            ->where('parent_id', 0)
            ->select(['id','name','slug','parent_id','created_at'])->latest()->get();;
    }

    public function getAllCategories()
    {
        return $this->getAll();
    }

    public function deleteMultiple(array $ids): int
    {
        return $this->model->whereIn('id', $ids)->delete();
    }
}

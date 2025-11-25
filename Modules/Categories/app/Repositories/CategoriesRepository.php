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

    public function getCategories($limit)
    {
        return $this->model->latest()->paginate($limit);
    }

    public function getAllForDataTable()
    {
        return $this->model->select(['id','name','slug','parent_id','created_at'])->get();
    }

    public function getParentOptions($excludeId = null)
    {
        $query = $this->model->select(['id', 'name'])->orderBy('name');
        if ($excludeId) {
            $query->where('id', '<>', $excludeId);
        }
        return $query->get();
    }

    public function deleteMultiple(array $ids): int
    {
        return $this->model->whereIn('id', $ids)->delete();
    }
}

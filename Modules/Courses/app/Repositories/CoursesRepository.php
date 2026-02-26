<?php

namespace Modules\Courses\Repositories;

use App\Models\Scopes\ActiveScope;
use App\Repositories\BaseRepository;
use Modules\Courses\Models\Course;

class CoursesRepository extends BaseRepository implements CoursesRepositoryInterface
{
    public function getModel()
    {
        return Course::class;
    }

    /**
     * Lấy toàn bộ khóa học (dùng cho DataTables)
     */
    public function getAllCourses()
    {
        return $this->model
            ->withoutGlobalScope(ActiveScope::class)
            ->select([
                'id',
                'name',
                'slug',
                'teacher_id',
                'price',
                'status',
                'created_at'
            ])
            ->latest();
    }

    public function getCourse($id){
        return $this->model->withoutGlobalScope(ActiveScope::class)->find($id);
    }


    public function createCourseCategories($course, $data = [])
    {
        return $course->categories()->attach($data);
    }

    public function updateCourseCategories($course, $data = [])
    {
        return $course->categories()->sync($data);
    }

    public function getRelatedCategories($course)
    {
        $categories = $course->categories()->allRelatedIds()->toArray();
        return $categories;
    }

    /**
     * Xóa nhiều khóa học
     */
    public function deleteMultiple(array $ids): int
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    public function getCourses($limit){
        return $this->model->limit($limit)->latest()->paginate($limit);
    }

    public function deleteCourse($id){
        return $this->model->withoutGlobalScope(ActiveScope::class)->where('id', $id)->delete();
    }

    public function updateCourse($id, $data = []){
        $result = $this->getCourse($id);
        if($result){
            return $result->update($data );
        }
        return false;
    }
}

<?php

namespace Modules\Courses\Repositories;

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
            ->with(['teacher'])  // thêm để datatables dùng row.teacher.name không lỗi
            ->select([
                'id',
                'name',
                'slug',
                'teacher_id',
                'price',
                'status',
                'created_at'
            ])
            ->latest()
            ->get();
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
}

<?php

namespace Modules\Courses\Repositories;

use App\Repositories\BaseRepository;
use Modules\Courses\Models\Courses;

class CoursesRepository extends BaseRepository implements CoursesRepositoryInterface
{
    public function getModel()
    {
        return Courses::class;
    }
    /**
     * Lấy danh sách khóa học có phân trang
     */
    public function getCourse($limit)
    {
        return $this->model
            ->with(['teacher'])
            ->paginate($limit);
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

    /**
     * Xóa nhiều khóa học
     */
    public function deleteMultiple(array $ids): int
    {
        return $this->model->whereIn('id', $ids)->delete();
    }
}

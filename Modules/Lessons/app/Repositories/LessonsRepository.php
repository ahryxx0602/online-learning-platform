<?php

namespace Modules\Lessons\Repositories;

use App\Repositories\BaseRepository;
use Modules\Lessons\Models\Lesson;

class LessonsRepository extends BaseRepository implements LessonsRepositoryInterface
{
    public function getModel()
    {
        return Lesson::class;
    }

    /**
     * Lấy toàn bộ bài giảng (dùng cho DataTables)
     */
    public function getAllLessons($courseId = null)
    {
        $query = $this->model
            ->with(['course'])
            ->select([
                'id',
                'name',
                'slug',
                'video_id',
                'document_id',
                'parent_id',
                'course_id',
                'is_trial',
                'views',
                'position',
                'duration',
                'description',
                'created_at'
            ]);

        if ($courseId) {
            $query->where('course_id', $courseId);
        }

        return $query->orderBy('position')->latest()->get();
    }

    /**
     * Xóa nhiều bài giảng
     */
    public function deleteMultiple(array $ids): int
    {
        return $this->model->whereIn('id', $ids)->delete();
    }
}

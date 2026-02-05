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

    public function getPosition($courseId)
    {
        $result = $this->model->where('course_id', $courseId)->orderBy('id', 'desc')->count();
        return $result + 1;
    }

    public function getLessons($courseId)
    {
        return $this->model->with('subLessons')->whereCourseId($courseId)->whereParentId(0)->select([
            'id',
            'name',
            'slug',
            'parent_id',
            'view',
            'duration',
            'course_id'
        ])->latest();
    }

    /**
     * Lấy toàn bộ bài giảng (dùng cho DataTables)
     */
    public function getAllLessons($courseId = null)
    {
        $query = $this->model
            ->with(['video', 'document', 'children.video', 'children.document'])
            ->select(['id', 'name', 'slug', 'course_id', 'video_id', 'document_id', 'parent_id', 'is_trial', 'views', 'duration', 'created_at']);

        if ($courseId) {
            $query->where('course_id', $courseId);
        }

        return $query->latest();
    }

    /**
     * Lấy bài giảng theo phân cấp (parent trước, con sau) - giữ structure
     */
    public function getLessonsByHierarchy($courseId)
    {
        $lessons = $this->model
            ->with(['children.children' => function ($query) {
                $query->orderBy('position')->orderBy('id');
            }])
            ->where('course_id', $courseId)
            ->whereNull('parent_id')
            ->orderBy('position')
            ->orderBy('id')
            ->select(['id', 'name', 'slug', 'course_id', 'video_id', 'document_id', 'parent_id', 'is_trial', 'views', 'duration', 'created_at'])
            ->get();

        return $lessons;
    }

    /**
     * Chuyển đổi cấu trúc phân cấp thành danh sách phẳng với level
     */
    private function flattenLessons($lessons, $level = 0, &$result = [])
    {
        if (empty($result)) {
            $result = [];
        }

        foreach ($lessons as $lesson) {
            $lesson->level = $level;
            $result[] = $lesson;

            if ($lesson->children && count($lesson->children) > 0) {
                $this->flattenLessons($lesson->children, $level + 1, $result);
            }
        }

        return $result;
    }

    /**
     * Xóa nhiều bài giảng
     */
    public function deleteMultiple(array $ids): int
    {
        return $this->model->whereIn('id', $ids)->delete();
    }
}

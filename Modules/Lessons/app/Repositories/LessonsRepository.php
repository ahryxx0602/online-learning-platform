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
        return $this->model->with('subLessons')->whereCourseId($courseId)->whereNull('parent_id')
        ->select(['id', 'name', 'slug', 'is_trial', 'parent_id', 'views', 'duration', 'course_id'])
        ->orderBy('position', 'asc');
    }

    /**
     * Lấy toàn bộ bài giảng (dùng cho DataTables)
     */
    // public function getAllLessons($courseId = null)
    // {
    //     $query = $this->model
    //         ->with(['video', 'document', 'children.video', 'children.document'])
    //         ->select(['id', 'name', 'slug', 'course_id', 'video_id', 'document_id', 'parent_id', 'is_trial', 'views', 'duration', 'created_at']);

    //     if ($courseId) {
    //         $query->where('course_id', $courseId);
    //     }

    //     return $query->latest();
    // }

    public function getAllLessons($courseId)
    {
        return $this->model->where('course_id', $courseId)->get();
    }

    /**
     * Lấy bài giảng theo phân cấp (parent trước, con sau) - giữ structure
     */
    public function getLessonsByHierarchy($courseId) {
        return $this->model
            ->where('course_id', $courseId)
            ->whereNull('parent_id') // Chỉ lấy cấp cao nhất ở ngoài cùng
            ->with('subLessons')      // Load sẵn các cấp con
            ->orderBy('position', 'asc')
            ->get();
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

    public function getLessonCount($course){
        return (object)[
            'module' => $course->lessons()->whereNull('parent_id')->count(),
            'lessons' => $course->lessons()->whereNotNull('parent_id')->count()
        ];
    }
}

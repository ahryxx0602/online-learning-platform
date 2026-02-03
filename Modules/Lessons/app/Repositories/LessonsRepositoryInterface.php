<?php

namespace Modules\Lessons\Repositories;

use App\Repositories\RepositoryInterface;

interface LessonsRepositoryInterface extends RepositoryInterface
{
    /**
     * Lấy toàn bộ bài giảng (dùng cho DataTables)
     * @param int|null $courseId Lọc theo khóa học nếu có
     */
    public function getAllLessons($courseId = null);
    public function getPosition($courseId);
    /**
     * Xóa nhiều bài giảng
     */
    public function deleteMultiple(array $ids): int;

    public function getLessonsByHierarchy($courseId);
}

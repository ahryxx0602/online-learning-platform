<?php

use Modules\Lessons\Repositories\LessonsRepository;
use Modules\Lessons\Repositories\LessonsRepositoryInterface;

function getLessons($lessons, $old, $parentId = 0, $char='')
{
    $id = request()->route()->lessonId;
    if($lessons ){
        foreach($lessons as $key => $lesson){
            if($lesson->parent_id == $parentId && $id != $lesson->id){
                echo '<option value="'.$lesson->id.'"';
                if($old == $lesson->id){
                    echo ' selected';
                }
                echo '>'.$char.$lesson->name.'</option>';
                unset($lessons[$key]);
                getCategories($lessons, $old,  $lesson->id, $char.' |- ');
            }
        }
    }
}

function getTime($seconds) {
    $mins = floor($seconds / 60);
    $secs = floor($seconds % 60); // Dùng phép chia lấy dư % sẽ chuẩn hơn
    
    $mins = $mins < 10 ? '0' . $mins : $mins;
    $secs = $secs < 10 ? '0' . $secs : $secs;
    
    return "$mins:$secs";
}

function getLessonCount($course){
    $lessonRepository = app(LessonsRepositoryInterface::class);
    return $lessonRepository->getLessonCount($course);
}
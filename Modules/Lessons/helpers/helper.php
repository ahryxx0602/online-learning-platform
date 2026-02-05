<?php 

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
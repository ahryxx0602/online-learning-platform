<?php
// helper
function getCategoriesCheckbox($categories, $old, $parentId = 0, $char = '')
{
    $id = request()->route()->category;
    if ($categories) {
        foreach ($categories as $key => $category) {
            if ($category->parent_id == $parentId && $id != $category->id) {
                $checked = (is_array($old) && in_array($category->id, $old)) ? 'checked' : '';
                echo '<label class="d-block"><input name="categories[]" value="' . $category->id . '" type="checkbox" ' . $checked . '/>' . $char . $category->name . '</label>';
                unset($categories[$key]);
                getCategoriesCheckbox($categories, $old,  $category->id, $char . ' |- ');
            }
        }
    }
}

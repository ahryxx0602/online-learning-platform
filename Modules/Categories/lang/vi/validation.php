<?php

return [
    'required' => ':attribute không được để trống',
    'unique'   => ':attribute đã tồn tại',
    'integer'  => ':attribute phải là số',
    'min'      => ':attribute không hợp lệ',

    'parent_invalid'    => 'Danh mục cha không được là chính nó.',
    'parent_not_found'  => 'Danh mục cha không tồn tại.',

    'attributes' => [
        'name'      => 'Tên danh mục',
        'slug'      => 'Slug',
        'parent_id' => 'Danh mục cha',
    ],
];

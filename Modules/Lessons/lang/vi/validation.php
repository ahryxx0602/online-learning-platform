<?php

return [
    'required' => ':attribute bắt buộc phải nhập',
    'unique'   => ':attribute đã tồn tại',
    'integer'  => ':attribute phải là số nguyên',
    'numeric'  => ':attribute phải là số hợp lệ',
    'boolean'  => ':attribute phải là giá trị đúng/sai',
    'min'      => ':attribute phải lớn hơn hoặc bằng :min',
    'max'      => ':attribute không được vượt quá :max ký tự',
    'exists'   => ':attribute không tồn tại trong hệ thống',
    'string'   => ':attribute phải là chuỗi ký tự',

    'attributes' => [
        'name'        => 'Tên bài giảng',
        'slug'        => 'Slug',
        'course_id'   => 'Khóa học',
        'parent_id'   => 'Nhóm bài giảng',
        'is_trial'    => 'Học thử',
        'position'    => 'Thứ tự',
        'document'    => 'Tài liệu',
        'video'       => 'Video',
        'description' => 'Mô tả',
        'duration'    => 'Thời lượng',
        'views'       => 'Lượt xem',
    ],
];


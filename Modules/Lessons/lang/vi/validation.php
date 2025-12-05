<?php

return [
    'required' => ':attribute bắt buộc phải nhập',
    'unique'   => ':attribute đã tồn tại',
    'integer'  => ':attribute phải là số nguyên',
    'numeric'  => ':attribute phải là số hợp lệ',
    'boolean'  => ':attribute phải là giá trị đúng/sai',
    'min'      => ':attribute phải lớn hơn hoặc bằng :min',
    'max'      => ':attribute không được vượt quá :max ký tự',

    'attributes' => [
        'name'        => 'Tên bài giảng',
        'slug'        => 'Slug',
        'course_id'   => 'Khóa học',
        'video_id'    => 'Video',
        'document_id' => 'Tài liệu',
        'parent_id'   => 'Bài giảng cha',
        'is_trial'    => 'Học thử',
        'views'       => 'Lượt xem',
        'position'    => 'Thứ tự',
        'duration'    => 'Thời lượng',
        'description' => 'Mô tả',
    ],
];


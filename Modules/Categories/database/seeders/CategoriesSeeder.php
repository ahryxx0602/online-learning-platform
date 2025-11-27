<?php

namespace Modules\Categories\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Categories\Models\Category;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Lập trình Web',
            'Lập trình Mobile',
            'Khoa học máy tính',
            'Trí tuệ nhân tạo',
            'Phát triển Game',
            'Cơ sở dữ liệu',
            'DevOps',
            'Hệ điều hành',
            'Mạng máy tính',
            'Kỹ năng mềm',
            'Frontend Development',
            'Backend Development',
            'Fullstack Development',
            'UI/UX Design',
            'Cloud Computing',
            'Data Science',
            'Machine Learning',
            'Cyber Security',
            'Phân tích dữ liệu',
            'Hệ thống nhúng'
        ];

        foreach ($categories as $index => $name) {
            Category::create([
                'name'       => $name,
                'slug'       => Str::slug($name) . '-' . ($index + 1),
                'parent_id'  => 0, // tất cả là danh mục cha
                'created_at' => now()->subDays(rand(1, 30)),
            ]);
        }
    }
}

<?php

namespace Modules\Courses\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Courses\Models\Course;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coursesNames = [
            'Lập trình Laravel cơ bản',
            'Lập trình Laravel nâng cao',
            'NodeJS từ zero đến hero',
            'Học Java trong 30 ngày',
            'Khóa học ReactJS toàn tập',
            'Lập trình PHP từ A-Z',
            'Python cho người mới bắt đầu',
            'Thiết kế REST API chuyên nghiệp',
            'HTML/CSS cho người mới',
            'JavaScript nâng cao',
            'Khóa học Vue 3 cơ bản',
            'MySQL cho backend developer',
            'Docker dành cho lập trình viên',
            'Git & GitHub Mastery',
            'Khóa học DevOps cơ bản',
            'Linux cơ bản đến nâng cao',
            'Kỹ thuật phỏng vấn IT',
            'React Native thực chiến',
            'Khóa học Flutter toàn tập',
            'Khóa học C# .NET căn bản'
        ];

        foreach ($coursesNames as $index => $name) {

            Course::create([
                'name' => $name,
                'slug' => Str::slug($name) . '-' . ($index + 1),
                'detail' => 'Khóa học: ' . $name . ' — được thiết kế dành cho cả người mới bắt đầu và đã có kinh nghiệm.',

                // random teacher từ 1 - 5
                'teacher_id' => rand(1, 5),

                // thumbnail mẫu
                'thumbnail' => 'https://picsum.photos/seed/course' . ($index + 1) . '/600/400',

                // giá random 500.000 – 2.000.000
                'price' => rand(500000, 2000000),

                // sale_price (có khi không)
                'sale_price' => rand(0, 1) ? rand(300000, 1000000) : null,

                // code theo dạng COURSE001
                'code' => 'COURSE' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),

                // thời lượng 10 – 50 giờ
                'durations' => rand(10, 50),

                // có tài liệu hay không
                'is_document' => rand(0, 1),

                // mô tả hỗ trợ
                'supports' => 'Hỗ trợ online 24/7 qua group riêng.',

                // 1 = hiển thị, 0 = ẩn
                'status' => rand(0, 1),

                // thời gian random trong 30 ngày gần đây
                'created_at' => now()->subDays(rand(0, 30)),
            ]);
        }
    }
}

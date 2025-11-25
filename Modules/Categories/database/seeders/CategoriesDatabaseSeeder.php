<?php

namespace Modules\Categories\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->truncate();

        $categories = [
            [
                'name' => 'Lập trình Back-end',
                'children' => ['PHP', 'Laravel', 'NodeJS', 'Java Spring'],
            ],
            [
                'name' => 'Lập trình Front-end',
                'children' => ['HTML/CSS', 'JavaScript', 'VueJS', 'ReactJS'],
            ],
            [
                'name' => 'Mobile App',
                'children' => ['Android', 'iOS', 'Flutter', 'React Native'],
            ],
            [
                'name' => 'Khoa học dữ liệu',
                'children' => ['Python', 'Machine Learning', 'Deep Learning', 'Data Visualization'],
            ],
            [
                'name' => 'Thiết kế (Design)',
                'children' => ['UI/UX', 'Photoshop', 'Illustrator', 'Figma'],
            ],
            [
                'name' => 'Kỹ năng mềm',
                'children' => ['Giao tiếp', 'Thuyết trình', 'Làm việc nhóm', 'Quản lý thời gian'],
            ],
        ];

        foreach ($categories as $cat) {

            // Parent
            $parentId = DB::table('categories')->insertGetId([
                'name'       => $cat['name'],
                'slug'       => Str::slug($cat['name']),
                'parent_id'  => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Children
            foreach ($cat['children'] as $child) {
                DB::table('categories')->insert([
                    'name'       => $child,
                    'slug'       => Str::slug($child),
                    'parent_id'  => $parentId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

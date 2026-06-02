<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Điện thoại', 'Laptop', 'Máy tính bảng', 'Phụ kiện', 'Đồng hồ', 'Tai nghe', 'Loa', 'Camera', 'Màn hình', 'Chuột'];

        foreach ($categories as $index => $name) {
            DB::table('categories')->insert([
                'catename'    => $name,
                'slug'        => Str::slug($name),
                'status'      => rand(0, 1),
                'sort_order'  => $index + 1,
                'description' => fake()->sentence(10),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}

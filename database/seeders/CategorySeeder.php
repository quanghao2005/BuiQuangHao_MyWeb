<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Danh sách các danh mục bạn muốn tạo
        $categories = ['Điện thoại', 'Laptop', 'Máy tính bảng', 'Phụ kiện', 'Đồng hồ', 'Tai nghe', 'Loa', 'Camera', 'Màn hình', 'Chuột'];

        foreach ($categories as $name) {
            DB::table('categories')->insert([
                'catename'   => $name,
                'slug'       => Str::slug($name),
                'image'      => null,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

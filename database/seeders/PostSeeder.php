<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $title = fake()->sentence(rand(4, 8)); // Tạo ngẫu nhiên tiêu đề bài viết

            DB::table('posts')->insert([
                'title'      => $title,
                'slug'       => Str::slug($title) . '-' . $i, // Đảm bảo tính duy nhất bằng cách đính kèm ID vòng lặp
                'content'    => fake()->paragraphs(3, true),  // Tạo 3 đoạn văn nội dung mẫu
                'image'      => 'post-' . rand(1, 5) . '.jpg', // Ví dụ: post-1.jpg, post-2.jpg
                'status'     => rand(0, 1),
                'user_id'    => rand(1, 5),   // Giả định hệ thống của bạn đã có các User mang ID từ 1 đến 5
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

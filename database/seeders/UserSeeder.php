<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'fullname'   => fake()->name(),
                'username'   => fake()->unique()->userName(),
                'email'      => fake()->unique()->safeEmail(),
                'password'   => md5('123456'), // Tài liệu thiết kế VARCHAR(50) nên sử dụng md5 hoặc chuỗi text thường để test nhanh phù hợp độ dài.
                'phone'      => fake()->unique()->phoneNumber(),
                'address'    => fake()->address(),
                'gender'     => fake()->randomElement([0, 1, 2]), // 1: Nam, 2: Nữ, 0: Khác
                'birthday'   => fake()->date('Y-m-d', '2005-01-01'), // Ngày sinh ngẫu nhiên trước năm 2005
                'role'       => fake()->randomElement([1, 2]), // 1: quản lý, 2: nhân viên
                'status'     => fake()->numberBetween(0, 1), // 1: kích hoạt, 0: khóa
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

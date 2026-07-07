<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo tài khoản admin mặc định để dễ test
        DB::table('users')->insert([
            'fullname'   => 'Quản trị viên',
            'username'   => 'admin',
            'email'      => 'admin@example.com',
            'password'   => Hash::make('password'),
            'phone'      => '0123456789',
            'address'    => 'Hà Nội',
            'gender'     => 1,
            'birthday'   => '2000-01-01',
            'role'       => 1, // quản lý
            'status'     => 1, // kích hoạt
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'fullname'   => fake()->name(),
                'username'   => fake()->unique()->userName(),
                'email'      => fake()->unique()->safeEmail(),
                'password'   => Hash::make('123456'), // Sử dụng Hash::make thay vì md5
                'phone'      => fake()->unique()->phoneNumber(),
                'address'    => fake()->address(),
                'gender'     => fake()->randomElement([0, 1, 2]),
                'birthday'   => fake()->date('Y-m-d', '2005-01-01'),
                'role'       => fake()->randomElement([1, 2]),
                'status'     => fake()->numberBetween(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

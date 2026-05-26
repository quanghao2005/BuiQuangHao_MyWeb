<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'fullname' => 'Quản Trị Viên',
            'email' => 'admin@gmail.com',
            'phone' => '0987654321',
            'image' => 'admin.png',
            'role' => 'admin',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        for ($i = 1; $i <= 4; $i++) {
            $name = fake()->name();
            DB::table('users')->insert([
                'username' => fake()->unique()->userName(),
                'password' => Hash::make('123456'),
                'fullname' => $name,
                'email' => fake()->unique()->safeEmail(),
                'phone' => fake()->phoneNumber(),
                'image' => 'user' . $i . '.png',
                'role' => 'user',
                'status' => fake()->numberBetween(0, 1),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
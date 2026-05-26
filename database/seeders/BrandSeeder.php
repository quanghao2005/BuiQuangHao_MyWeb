<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $name = fake()->unique()->company();

            DB::table('brands')->insert([
                'brandname' => $name,
                'slug' => Str::slug($name),
                'image' => 'brand' . $i . '.png',
                'status' => fake()->numberBetween(0, 1),
                'sort_order' => $i,
                'description' => fake()->paragraph(2),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
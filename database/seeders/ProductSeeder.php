<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// Bổ sung 2 dòng use dưới đây để không bị lỗi Class not found
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy danh sách ID hiện có để đảm bảo khóa ngoại không bị lỗi
        // Nếu không có category hoặc brand nào, seeder sẽ dừng để tránh lỗi
        $brandIds = DB::table('brands')->pluck('brandid')->toArray();
        $cateIds = DB::table('categories')->pluck('cateid')->toArray();

        if (empty($brandIds) || empty($cateIds)) {
            $this->command->error('Vui lòng chạy CategorySeeder và BrandSeeder trước!');
            return;
        }

        for ($i = 1; $i <= 50; $i++) {
            $productName = fake()->unique()->words(rand(2, 5), true);
            $price = rand(100000, 50000000);

            DB::table('products')->insert([
                'productname'   => ucfirst($productName),
                'slug'          => Str::slug($productName) . '-' . Str::random(5), // Dùng random string để tránh trùng slug
                'price'         => $price,
                'pricediscount' => rand($price * 0.7, $price * 0.9),
                'image'         => 'product-' . rand(1, 10) . '.jpg',
                'description'   => fake()->paragraph(),
                'status'        => rand(0, 1),
                'brandid'       => $brandIds[array_rand($brandIds)], // Lấy ID ngẫu nhiên từ DB
                'cateid'        => $cateIds[array_rand($cateIds)],   // Lấy ID ngẫu nhiên từ DB
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}

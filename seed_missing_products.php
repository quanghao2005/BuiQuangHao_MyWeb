<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

$categories = Category::all();
$brand = Brand::inRandomOrder()->first(); 

$addedCount = 0;
foreach ($categories as $category) {
    $count = Product::where('cateid', $category->cateid)->count();
    if ($count == 0) {
        for ($i = 1; $i <= 3; $i++) {
            $name = $category->catename . ' Cao cấp - Mẫu ' . $i;
            $price = rand(100, 3000) * 10000; // Giá ngẫu nhiên từ 1tr đến 30tr
            Product::create([
                'productname' => $name,
                'slug' => Str::slug($name) . '-' . rand(1000, 9999),
                'price' => $price,
                'pricediscount' => $price * 0.9,
                'image' => 'product-' . rand(1, 10) . '.jpg',
                'description' => 'Sản phẩm ' . $category->catename . ' chất lượng cao, chính hãng, bảo hành 12 tháng.',
                'status' => 1,
                'brandid' => $brand ? $brand->brandid : 1,
                'cateid' => $category->cateid
            ]);
            $addedCount++;
        }
    }
}

echo "Đã thêm $addedCount sản phẩm cho các danh mục trống!";

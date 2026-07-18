<?php
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Str;

// 1. Thêm 5 Danh mục
$categories = [
    'Bàn phím',
    'Cáp sạc',
    'Ốp lưng',
    'Thiết bị mạng',
    'PC Lắp ráp'
];

$newCategoryIds = [];
foreach ($categories as $cat) {
    $slug = Str::slug($cat);
    $category = Category::updateOrCreate(
        ['slug' => $slug],
        [
            'catename' => $cat,
            'status' => 1,
            'sort_order' => 1
        ]
    );
    $newCategoryIds[] = $category->cateid;
}

// 2. Thêm 5 Thương hiệu
$brands = [
    'Logitech',
    'Anker',
    'Spigen',
    'TP-Link',
    'Corsair'
];

$newBrandIds = [];
foreach ($brands as $br) {
    $slug = Str::slug($br);
    $brand = Brand::updateOrCreate(
        ['slug' => $slug],
        [
            'brandname' => $br,
            'status' => 1,
            'sort_order' => 1
        ]
    );
    $newBrandIds[] = $brand->brandid;
}

// 3. Sửa lại một số sản phẩm hiện tại để gán vào các danh mục và thương hiệu này
$products = Product::all();

if ($products->count() > 0) {
    foreach ($products as $index => $product) {
        // Chỉ đổi thông tin của khoảng 1/3 số sản phẩm để làm mẫu, 
        // hoặc gán xoay vòng cho tất cả sản phẩm
        $catId = $newCategoryIds[$index % count($newCategoryIds)];
        $brandId = $newBrandIds[$index % count($newBrandIds)];
        
        $product->cateid = $catId;
        $product->brandid = $brandId;
        $product->save();
    }
}
echo "Đã thêm 5 danh mục, 5 thương hiệu và cập nhật sản phẩm thành công!";

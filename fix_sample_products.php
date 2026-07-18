<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

$productsToFix = Product::where('productname', 'like', '%Mẫu%')->get();

$realData = [
    'Bàn phím' => [
        ['name' => 'Bàn phím cơ AKKO 3098B Multi-modes', 'brand' => 'Logitech', 'price' => 1990000],
        ['name' => 'Bàn phím Razer BlackWidow V3', 'brand' => 'Logitech', 'price' => 3290000],
        ['name' => 'Bàn phím không dây Keychron K8 Pro', 'brand' => 'Logitech', 'price' => 2490000],
    ],
    'Cáp sạc' => [
        ['name' => 'Cáp sạc nhanh Anker PowerLine III USB-C to Lightning', 'brand' => 'Anker', 'price' => 450000],
        ['name' => 'Cáp sạc Baseus Tungsten Gold Fast Charging', 'brand' => 'Anker', 'price' => 250000],
        ['name' => 'Cáp bọc dù UGREEN Type-C 100W', 'brand' => 'Anker', 'price' => 350000],
    ],
    'Ốp lưng' => [
        ['name' => 'Ốp lưng UAG Plasma cho iPhone 15 Pro Max', 'brand' => 'Spigen', 'price' => 950000],
        ['name' => 'Ốp lưng nhám Nillkin Super Frosted Shield', 'brand' => 'Spigen', 'price' => 250000],
        ['name' => 'Ốp lưng da thật Memumi Slim', 'brand' => 'Spigen', 'price' => 450000],
    ],
    'Thiết bị mạng' => [
        ['name' => 'Router Wifi Mesh Deco X20 (2-Pack)', 'brand' => 'TP-Link', 'price' => 3290000],
        ['name' => 'Bộ mở rộng sóng Wifi TP-Link RE305', 'brand' => 'TP-Link', 'price' => 650000],
        ['name' => 'Switch Gigabit 8 Cổng TP-Link TL-SG108', 'brand' => 'TP-Link', 'price' => 490000],
    ],
    'PC Lắp ráp' => [
        ['name' => 'PC Gaming i5-12400F / RTX 3060 12GB', 'brand' => 'Asus', 'price' => 18500000],
        ['name' => 'PC Đồ họa i7-13700K / RTX 4070 Ti', 'brand' => 'Asus', 'price' => 45900000],
        ['name' => 'PC Văn phòng Pentium G6400 / 8GB / SSD 256GB', 'brand' => 'Dell', 'price' => 5500000],
    ],
    'Màn hình' => [
        ['name' => 'Màn hình LG UltraGear 27GN800-B 27" 2K 144Hz', 'brand' => 'Samsung', 'price' => 7500000],
        ['name' => 'Màn hình Dell UltraSharp U2723QE 27" 4K', 'brand' => 'Dell', 'price' => 14900000],
        ['name' => 'Màn hình cong Samsung Odyssey G5 27" 2K', 'brand' => 'Samsung', 'price' => 6900000],
    ],
    'Phụ kiện' => [
        ['name' => 'Giá đỡ laptop hợp kim nhôm Nillkin', 'brand' => 'Anker', 'price' => 350000],
        ['name' => 'Lót chuột RGB Razer Goliathus', 'brand' => 'Logitech', 'price' => 850000],
        ['name' => 'Hub chuyển đổi Ugreen 6-in-1 Type C', 'brand' => 'Anker', 'price' => 950000],
    ],
    'Chuột' => [
        ['name' => 'Chuột Gaming Logitech G102 Lightsync', 'brand' => 'Logitech', 'price' => 390000],
        ['name' => 'Chuột không dây Razer Orochi V2', 'brand' => 'Logitech', 'price' => 1290000],
        ['name' => 'Chuột Ergonomic Anker Vertical', 'brand' => 'Anker', 'price' => 590000],
    ],
    'Camera' => [
        ['name' => 'Camera hành trình GoPro Hero 12 Black', 'brand' => 'Sony', 'price' => 10500000],
        ['name' => 'Máy ảnh Sony Alpha A6400 Kit 16-50mm', 'brand' => 'Sony', 'price' => 22500000],
        ['name' => 'Webcam Logitech C922 Pro Stream', 'brand' => 'Logitech', 'price' => 2590000],
    ]
];

$brandCache = [];
function getBrandId($brandName) {
    global $brandCache;
    if (isset($brandCache[$brandName])) return $brandCache[$brandName];
    $b = Brand::where('brandname', 'like', "%$brandName%")->first();
    if ($b) {
        $brandCache[$brandName] = $b->brandid;
        return $b->brandid;
    }
    return 1;
}

$updatedCount = 0;
$counters = [];

foreach ($productsToFix as $product) {
    $cat = Category::find($product->cateid);
    if ($cat) {
        $catName = $cat->catename;
        if (!isset($counters[$catName])) {
            $counters[$catName] = 0;
        }
        
        $index = $counters[$catName] % 3;
        
        if (isset($realData[$catName][$index])) {
            $data = $realData[$catName][$index];
            $product->productname = $data['name'];
            $product->slug = Str::slug($data['name']) . '-' . rand(100, 999);
            $product->price = $data['price'];
            $product->pricediscount = $data['price'] * 0.95; // Giảm 5%
            $product->brandid = getBrandId($data['brand']);
            $product->save();
            $counters[$catName]++;
            $updatedCount++;
        }
    }
}

echo "Đã sửa thành công $updatedCount sản phẩm mẫu thành tên thật!";

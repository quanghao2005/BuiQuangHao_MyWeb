<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

Schema::disableForeignKeyConstraints();
DB::table('products')->truncate();
Schema::enableForeignKeyConstraints();

// Tạo các thương hiệu thật nếu chưa có
$realBrands = ['Apple', 'Samsung', 'Dell', 'Asus', 'Sony', 'JBL', 'Logitech', 'Anker', 'Spigen', 'TP-Link'];
$brandIds = [];
foreach($realBrands as $bName) {
    $brand = Brand::firstOrCreate(
        ['slug' => Str::slug($bName)],
        ['brandname' => $bName, 'status' => 1, 'sort_order' => 1]
    );
    $brandIds[$bName] = $brand->brandid;
}

// Lấy ID các danh mục
function getCatId($name) {
    $cat = Category::where('catename', 'like', "%$name%")->first();
    return $cat ? $cat->cateid : Category::first()->cateid;
}
$catPhone = getCatId('Điện thoại');
$catLaptop = getCatId('Laptop');
$catTablet = getCatId('Máy tính bảng');
$catWatch = getCatId('Đồng hồ');
$catHeadphone = getCatId('Tai nghe');
$catSpeaker = getCatId('Loa');
$catMouse = getCatId('Chuột');
$catKeyboard = getCatId('Bàn phím');
$catCable = getCatId('Cáp sạc');
$catCase = getCatId('Ốp lưng');
$catNetwork = getCatId('Thiết bị mạng');

// Dữ liệu sản phẩm thật
$realProducts = [
    // Điện thoại
    ['name' => 'iPhone 15 Pro Max 256GB', 'price' => 34990000, 'discount' => 32990000, 'brand' => 'Apple', 'cat' => $catPhone],
    ['name' => 'Samsung Galaxy S24 Ultra 5G', 'price' => 33990000, 'discount' => 31990000, 'brand' => 'Samsung', 'cat' => $catPhone],
    ['name' => 'iPhone 14 128GB', 'price' => 19990000, 'discount' => 18490000, 'brand' => 'Apple', 'cat' => $catPhone],
    // Laptop
    ['name' => 'MacBook Air M2 2022 8GB/256GB', 'price' => 27990000, 'discount' => 24990000, 'brand' => 'Apple', 'cat' => $catLaptop],
    ['name' => 'Dell XPS 13 Plus 9320', 'price' => 45990000, 'discount' => 42990000, 'brand' => 'Dell', 'cat' => $catLaptop],
    ['name' => 'Asus ROG Strix G15', 'price' => 29990000, 'discount' => 27990000, 'brand' => 'Asus', 'cat' => $catLaptop],
    // Máy tính bảng
    ['name' => 'iPad Pro 11 inch M2 2022 WiFi 128GB', 'price' => 23990000, 'discount' => 21990000, 'brand' => 'Apple', 'cat' => $catTablet],
    ['name' => 'Samsung Galaxy Tab S9 Ultra', 'price' => 32990000, 'discount' => 29990000, 'brand' => 'Samsung', 'cat' => $catTablet],
    // Phụ kiện / Đồng hồ / Âm thanh
    ['name' => 'Apple Watch Series 9 GPS 41mm', 'price' => 10490000, 'discount' => 9890000, 'brand' => 'Apple', 'cat' => $catWatch],
    ['name' => 'AirPods Pro 2 (USB-C)', 'price' => 6190000, 'discount' => 5790000, 'brand' => 'Apple', 'cat' => $catHeadphone],
    ['name' => 'Tai nghe Bluetooth Sony WH-1000XM5', 'price' => 7990000, 'discount' => 6990000, 'brand' => 'Sony', 'cat' => $catHeadphone],
    ['name' => 'Loa Bluetooth JBL Charge 5', 'price' => 3990000, 'discount' => 3490000, 'brand' => 'JBL', 'cat' => $catSpeaker],
    // Gaming Gear & Network
    ['name' => 'Chuột Không Dây Logitech MX Master 3S', 'price' => 2490000, 'discount' => 2290000, 'brand' => 'Logitech', 'cat' => $catMouse],
    ['name' => 'Bàn phím cơ Logitech G Pro X TKL', 'price' => 3490000, 'discount' => 3190000, 'brand' => 'Logitech', 'cat' => $catKeyboard],
    ['name' => 'Củ sạc nhanh Anker 735 GaNPrime 65W', 'price' => 1290000, 'discount' => 990000, 'brand' => 'Anker', 'cat' => $catCable],
    ['name' => 'Ốp lưng Spigen Liquid Crystal iPhone 15 Pro Max', 'price' => 450000, 'discount' => 390000, 'brand' => 'Spigen', 'cat' => $catCase],
    ['name' => 'Router Wifi 6 TP-Link Archer AX55', 'price' => 1890000, 'discount' => 1590000, 'brand' => 'TP-Link', 'cat' => $catNetwork],
];

foreach ($realProducts as $p) {
    Product::create([
        'productname' => $p['name'],
        'slug' => Str::slug($p['name']),
        'price' => $p['price'],
        'pricediscount' => $p['discount'],
        'image' => 'product-' . rand(1, 10) . '.jpg',
        'description' => 'Sản phẩm chính hãng, bảo hành 12 tháng.',
        'status' => 1,
        'brandid' => $brandIds[$p['brand']],
        'cateid' => $p['cat']
    ]);
}

echo "Đã xóa sản phẩm rác và thêm " . count($realProducts) . " sản phẩm thật thành công!";

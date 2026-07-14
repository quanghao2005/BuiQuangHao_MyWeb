<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // 8 Sản phẩm mới nhất
        $newProducts = Product::where('status', 1)->orderBy('created_at', 'desc')->take(8)->get();
        
        // 8 Sản phẩm giảm giá
        $discountProducts = Product::where('status', 1)->where('pricediscount', '>', 0)->orderBy('pricediscount', 'desc')->take(8)->get();
        
        // 8 Sản phẩm bán chạy (Tạm thời lấy ngẫu nhiên vì chưa có logic tính bán chạy)
        $bestSellerProducts = Product::where('status', 1)->inRandomOrder()->take(8)->get();

        return view('client.home.index', compact('newProducts', 'discountProducts', 'bestSellerProducts'));
    }
}

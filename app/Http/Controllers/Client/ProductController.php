<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductController extends Controller
{
    // Chi tiết sản phẩm
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->where('status', 1)->firstOrFail();
        // Lấy sản phẩm liên quan (cùng danh mục)
        $relatedProducts = Product::where('cateid', $product->cateid)
                            ->where('id', '!=', $product->id)
                            ->where('status', 1)
                            ->take(4)->get();
        return view('client.product.show', compact('product', 'relatedProducts'));
    }

    // Lọc theo danh mục
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->where('status', 1)->firstOrFail();
        $products = Product::where('cateid', $category->cateid)->where('status', 1)->paginate(12);
        
        $title = 'Danh mục: ' . $category->catename;
        return view('client.product.index', compact('products', 'title'));
    }

    // Lọc theo thương hiệu
    public function brand($slug)
    {
        $brand = Brand::where('slug', $slug)->where('status', 1)->firstOrFail();
        $products = Product::where('brandid', $brand->brandid)->where('status', 1)->paginate(12);
        
        $title = 'Thương hiệu: ' . $brand->brandname;
        return view('client.product.index', compact('products', 'title'));
    }

    // Tìm kiếm
    public function search(Request $request)
    {
        $keyword = $request->input('q');
        $products = Product::where('productname', 'like', '%' . $keyword . '%')
                    ->where('status', 1)
                    ->paginate(12);
        $products->appends(['q' => $keyword]); // Giữ nguyên query string khi chuyển trang
        
        $title = 'Kết quả tìm kiếm cho: "' . $keyword . '"';
        return view('client.product.index', compact('products', 'title'));
    }
}

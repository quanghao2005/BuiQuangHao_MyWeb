<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductController extends Controller
{
    // Tất cả sản phẩm
    public function index(Request $request)
    {
        $query = Product::where('status', 1);
        $this->applyPriceFilter($query, $request);
        $products = $query->orderBy('created_at', 'desc')->paginate(8);
        $products->appends($request->all());
        
        if ($request->ajax()) {
            return response()->json([
                'html' => view('client.product.partials.product_list', compact('products'))->render(),
                'next_page_url' => $products->nextPageUrl()
            ]);
        }
        
        $title = 'Tất cả sản phẩm';
        return view('client.product.index', compact('products', 'title'));
    }

    // Chi tiết sản phẩm
    public function show($slug)
    {
        $product = Product::with('images')->where('slug', $slug)->where('status', 1)->firstOrFail();
        // Lấy sản phẩm liên quan (cùng danh mục)
        $relatedProducts = Product::where('cateid', $product->cateid)
                            ->where('id', '!=', $product->id)
                            ->where('status', 1)
                            ->take(4)->get();
        return view('client.product.show', compact('product', 'relatedProducts'));
    }

    // Lọc theo danh mục
    public function category(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->where('status', 1)->firstOrFail();
        $query = Product::where('cateid', $category->cateid)->where('status', 1);
        $this->applyPriceFilter($query, $request);
        $products = $query->orderBy('created_at', 'desc')->paginate(8);
        $products->appends($request->all());
        
        if ($request->ajax()) {
            return response()->json([
                'html' => view('client.product.partials.product_list', compact('products'))->render(),
                'next_page_url' => $products->nextPageUrl()
            ]);
        }
        
        $title = 'Danh mục: ' . $category->catename;
        return view('client.product.index', compact('products', 'title'));
    }

    // Lọc theo thương hiệu
    public function brand(Request $request, $slug)
    {
        $brand = Brand::where('slug', $slug)->where('status', 1)->firstOrFail();
        $query = Product::where('brandid', $brand->brandid)->where('status', 1);
        $this->applyPriceFilter($query, $request);
        $products = $query->orderBy('created_at', 'desc')->paginate(8);
        $products->appends($request->all());
        
        if ($request->ajax()) {
            return response()->json([
                'html' => view('client.product.partials.product_list', compact('products'))->render(),
                'next_page_url' => $products->nextPageUrl()
            ]);
        }
        
        $title = 'Thương hiệu: ' . $brand->brandname;
        return view('client.product.index', compact('products', 'title'));
    }

    // Tìm kiếm
    public function search(Request $request)
    {
        $keyword = $request->input('q');
        $query = Product::where('productname', 'like', '%' . $keyword . '%')->where('status', 1);
        $this->applyPriceFilter($query, $request);
        $products = $query->orderBy('created_at', 'desc')->paginate(8);
        $products->appends(['q' => $keyword]); // Giữ nguyên query string khi chuyển trang
        
        if ($request->ajax()) {
            return response()->json([
                'html' => view('client.product.partials.product_list', compact('products'))->render(),
                'next_page_url' => $products->nextPageUrl()
            ]);
        }
        
        $title = 'Kết quả tìm kiếm cho: "' . $keyword . '"';
        return view('client.product.index', compact('products', 'title'));
    }

    // Tìm kiếm Ajax (Real-time)
    public function ajaxSearch(Request $request)
    {
        $keyword = $request->input('q');
        if (empty($keyword)) {
            return response()->json([]);
        }
        $products = Product::where('productname', 'like', '%' . $keyword . '%')
                    ->where('status', 1)
                    ->limit(5)
                    ->get(['id', 'productname', 'slug', 'image', 'price', 'pricediscount']);
        
        // append full image url for frontend
        $products->transform(function($product) {
            $product->image_url = asset('storage/products/' . ($product->image ? $product->image : 'no-image.jpg'));
            $product->url = route('products.show', $product->slug);
            $product->price_format = number_format($product->price, 0, ',', '.') . 'đ';
            if ($product->pricediscount > 0) {
                $product->discount_format = number_format($product->pricediscount, 0, ',', '.') . 'đ';
            } else {
                $product->discount_format = null;
            }
            return $product;
        });

        return response()->json($products);
    }

    // Hàm áp dụng filter giá chung
    private function applyPriceFilter($query, Request $request)
    {
        if ($request->has('min_price') && is_numeric($request->min_price)) {
            $query->whereRaw('IF(pricediscount > 0, pricediscount, price) >= ?', [$request->min_price]);
        }
        if ($request->has('max_price') && is_numeric($request->max_price)) {
            $query->whereRaw('IF(pricediscount > 0, pricediscount, price) <= ?', [$request->max_price]);
        }
    }
}

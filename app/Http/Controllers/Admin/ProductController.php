<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        $list = Product::with(['category', 'brand'])
            ->orderBy('id', 'desc')
            ->paginate($limit);

        return view('admin.products.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {

        try {
            Product::create([
                'productname'   => $request->productname,
                'slug'          => $request->slug ?? Str::slug($request->productname),
                'cateid'        => $request->cateid,
                'brandid'       => $request->brandid,
                'price'         => $request->price,
                'pricediscount' => $request->pricediscount ?? 0,
                'description'   => $request->description,
                'status'        => $request->status ?? 1,
                'image'         => $request->image ?? null,
            ]);

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['category', 'brand'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {

        try {
            // Bước 1 theo Lab: Kiểm tra thủ công (không dùng $request->validate) cho cateid
            if (empty($request->cateid)) {
                return back()
                    ->withInput()
                    ->with('error', 'Vui lòng chọn loại sản phẩm');
            }

            // Bước 2 theo Lab: Tìm sản phẩm
            $product = Product::find($id);

            if (!$product) {
                return redirect()
                    ->route('admin.products.index')
                    ->with('error', 'Sản phẩm không tồn tại');
            }

            // Bước 3: Cập nhật dữ liệu
            $product->update([
                'productname'   => $request->productname,
                'slug'          => $request->slug ?? Str::slug($request->productname), // THÊM: Cập nhật cả slug
                'cateid'        => $request->cateid,
                'brandid'       => $request->brandid,
                'price'         => $request->price,
                'pricediscount' => $request->pricediscount,
                'status'        => $request->status,
                'description'   => $request->description,
            ]);

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Cập nhật sản phẩm thành công');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Product::findOrFail($id)->delete();
            return redirect()->route('admin.products.index')->with('success', 'Đã xóa sản phẩm!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi xóa sản phẩm: ' . $e->getMessage());
        }
    }

    // ================== CÁC HÀM TEST CỦA BẠN ==================
    public function test1()
    {
        return redirect()->route('admin.dashboard');
    }

    public function test2()
    {
        return redirect('/admin/dashboard');
    }
}

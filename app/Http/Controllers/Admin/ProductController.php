<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str; // Import thư viện Str để tự động tạo Slug

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        // Sử dụng Eager Loading (with) để lấy dữ liệu từ bảng liên kết, tránh lỗi N+1 Query
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
        // Lấy danh sách danh mục và thương hiệu đang hiển thị (status = 1) để đổ vào dropdown
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'productname' => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'cateid'      => 'required',
            'brandid'     => 'required',
        ]);

        Product::create([
            'productname' => $request->productname,
            // Tự động chuyển "Tên SP" thành "ten-sp" để làm đường dẫn (slug)
            'slug'        => $request->slug ?? Str::slug($request->productname),
            'price'       => $request->price,
            'cateid'      => $request->cateid,
            'brandid'     => $request->brandid,
            'status'      => $request->status ?? 1,
            'image'       => $request->image ?? null,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
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
    public function update(Request $request, string $id)
    {
        $request->validate([
            'productname' => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'cateid'      => 'required',
            'brandid'     => 'required',
        ]);

        // Tìm sản phẩm cần sửa (Sẽ báo lỗi 404 nếu không tìm thấy)
        $product = Product::findOrFail($id);

        $product->update([
            'productname' => $request->productname,
            // Cập nhật lại slug nếu tên sản phẩm thay đổi
            'slug'        => $request->slug ?? Str::slug($request->productname),
            'price'       => $request->price,
            'cateid'      => $request->cateid,
            'brandid'     => $request->brandid,
            'status'      => $request->status,
            // Nếu có ảnh mới thì lấy ảnh mới, không thì giữ nguyên ảnh cũ trong DB
            'image'       => $request->image ?? $product->image,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cách chuẩn của Eloquent để xóa dữ liệu
        Product::findOrFail($id)->delete();

        return redirect()->route('admin.products.index')->with('success', 'Đã xóa sản phẩm!');
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

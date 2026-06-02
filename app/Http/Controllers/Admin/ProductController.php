<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = DB::table('products')
            // SỬA: 'categories.id' thành 'categories.cateid'
            ->join('categories', 'products.cateid', '=', 'categories.cateid')

            // SỬA: 'brands.id' thành 'brands.brandid'
            ->leftJoin('brands', 'products.brandid', '=', 'brands.brandid')

            ->select(
                'products.id',
                'products.productname',
                'products.image',
                'products.price',
                'products.status',
                'categories.catename',
                'brands.brandname'
            )
            ->orderBy('products.id', 'desc')
            ->get();

        return view('admin.products.index', compact('list'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Xóa sản phẩm
        DB::table('products')->where('id', $id)->delete();
        return redirect()->route('admin.products.index')->with('success', 'Đã xóa sản phẩm!');
    }

    // Các hàm khác để trống hoặc triển khai sau
    public function create()
    {
        return view('admin.products.create');
    }
    public function store(Request $request)
    { /* Xử lý thêm */
    }
    public function show(string $id)
    { /* Xem chi tiết */
    }
    public function edit(string $id)
    { /* Form sửa */
    }
    public function update(Request $request, string $id)
    { /* Xử lý sửa */
    }

    // Các hàm test của bạn giữ nguyên
    public function test1()
    {
        return redirect()->route('admin.dashboard');
    }
    public function test2()
    {
        return redirect('/admin/dashboard');
    }
}

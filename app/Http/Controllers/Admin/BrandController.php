<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import Facade DB để sử dụng Query Builder

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     * (Đáp ứng Câu C: Hiển thị danh sách thương hiệu)
     */
    public function index()
    {
        // Đổi cột 'id' thành 'brandid' để phù hợp với cơ sở dữ liệu
        $list = DB::table('brands')
            ->select('brandid', 'brandname', 'slug', 'image', 'status')
            ->orderBy('brandname', 'asc') // Sắp xếp theo tên thương hiệu từ A-Z
            ->get();

        // Trả về view index của thương hiệu và truyền biến $list sang giao diện
        return view('admin.brands.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::table('brands')->insert([
            'brandname'  => $request->brandname,
            'slug'       => $request->slug,
            'image'      => $request->image ?? null,
            'status'     => $request->status ?? 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.brands.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Để trống hoặc viết logic xem chi tiết nếu cần
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Sửa điều kiện tìm kiếm theo cột 'brandid'
        $brand = DB::table('brands')->where('brandid', $id)->first();
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Sửa điều kiện cập nhật theo cột 'brandid'
        DB::table('brands')
            ->where('brandid', $id)
            ->update([
                'brandname'  => $request->brandname,
                'slug'       => $request->slug,
                'image'      => $request->image ?? null,
                'status'     => $request->status,
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.brands.index');
    }

    /**
     * Remove the specified resource from storage.
     * (Đáp ứng Câu F: Thực hiện xóa dữ liệu với Query Builder)
     */
    public function destroy(string $id)
    {
        // Sửa điều kiện xóa dựa trên cột 'brandid'
        DB::table('brands')->where('brandid', $id)->delete();

        // Xóa xong quay trở lại trang danh sách thương hiệu
        return redirect()->route('admin.brands.index');
    }
}

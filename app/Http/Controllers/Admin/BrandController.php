<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        $list = Brand::select('brandid', 'brandname', 'slug', 'image', 'status')
            ->orderBy('brandname', 'asc')
            ->paginate($limit);

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
    public function store(BrandRequest $request)
    {

        try {
            Brand::create([
                'brandname' => $request->brandname,
                // Tự động tạo slug nếu người dùng bỏ trống
                'slug'      => $request->slug ?? Str::slug($request->brandname),
                'image'     => $request->image ?? null,
                'status'    => $request->status ?? 1,
            ]);

            return redirect()->route('admin.brands.index')->with('success', 'Thêm thương hiệu thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Lỗi khi thêm thương hiệu: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Phải dùng where vì khóa chính là 'brandid'
        $brand = Brand::where('brandid', $id)->firstOrFail();
        return view('admin.brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::where('brandid', $id)->firstOrFail();
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, string $id)
    {

        try {
            // Tìm thương hiệu theo 'brandid' và cập nhật
            $brand = Brand::where('brandid', $id)->firstOrFail();

            $brand->update([
                'brandname' => $request->brandname,
                'slug'      => $request->slug ?? Str::slug($request->brandname),
                'image'     => $request->image ?? $brand->image,
                'status'    => $request->status,
            ]);

            return redirect()->route('admin.brands.index')->with('success', 'Cập nhật thương hiệu thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Lỗi khi cập nhật thương hiệu: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Xóa theo 'brandid'
        Brand::where('brandid', $id)->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Đã xóa thương hiệu!');
    }
}

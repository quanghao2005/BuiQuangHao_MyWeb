<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
            // Upload hình ảnh chính
            $fileName = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = Str::slug($request->productname) . '-' . time() . '.' . $file->extension();
                $file->storeAs('products', $fileName, 'public');
            }

            $product = Product::create([
                'productname'   => $request->productname,
                'slug'          => $request->slug ?? Str::slug($request->productname),
                'cateid'        => $request->cateid,
                'brandid'       => $request->brandid,
                'price'         => $request->price,
                'pricediscount' => $request->pricediscount ?? 0,
                'description'   => $request->description,
                'status'        => $request->status ?? 1,
                'image'         => $fileName,
            ]);

            // Upload hình ảnh phụ
            if ($request->hasFile('imgs')) {
                $i = 1;
                $time = time();
                foreach ($request->file('imgs') as $file) {
                    $fileNameSub = $product->id . '_' . $time . '_' . $i . '.' . $file->extension();
                    $file->storeAs('products', $fileNameSub, 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $fileNameSub,
                    ]);
                    $i++;
                }
            }

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
        $product = Product::with('images')->findOrFail($id);
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
            // Bước 2 theo Lab: Tìm sản phẩm
            $product = Product::find($id);

            if (!$product) {
                return redirect()
                    ->route('admin.products.index')
                    ->with('error', 'Sản phẩm không tồn tại');
            }

            // Bước 3: Cập nhật dữ liệu
            $fileName = $product->image;
            if ($request->hasFile('img')) {
                if ($fileName) {
                    Storage::disk('public')->delete('products/' . $fileName);
                }
                $file = $request->file('img');
                $fileName = Str::slug($request->productname) . '-' . time() . '.' . $file->extension();
                $file->storeAs('products', $fileName, 'public');
            }

            $product->update([
                'productname'   => $request->productname,
                'slug'          => $request->slug ?? Str::slug($request->productname), // THÊM: Cập nhật cả slug
                'cateid'        => $request->cateid,
                'brandid'       => $request->brandid,
                'price'         => $request->price,
                'pricediscount' => $request->pricediscount,
                'status'        => $request->status,
                'description'   => $request->description,
                'image'         => $fileName,
            ]);

            // Xử lý thêm ảnh phụ nếu có
            if ($request->hasFile('imgs')) {
                $i = 1;
                $time = time();
                foreach ($request->file('imgs') as $file) {
                    $fileNameSub = $product->id . '_' . $time . '_' . $i . '.' . $file->extension();
                    $file->storeAs('products', $fileNameSub, 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $fileNameSub,
                    ]);
                    $i++;
                }
            }

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

    // ================== AJAX XÓA ẢNH PHỤ ==================
    public function deleteImage($id)
    {
        try {
            $image = ProductImage::findOrFail($id);
            if ($image->image) {
                Storage::disk('public')->delete('products/' . $image->image);
            }
            $image->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}

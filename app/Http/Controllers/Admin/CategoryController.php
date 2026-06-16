<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str; // Import thư viện tạo slug

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        $list = Category::select('cateid', 'catename', 'slug', 'image', 'status')
            ->orderBy('catename', 'asc')
            ->paginate($limit);

        return view('admin.categories.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'catename' => 'required|string|max:255|unique:categories,catename',
        ], [
            'catename.unique' => 'Tên danh mục này đã tồn tại, vui lòng nhập tên khác!',
            'catename.required' => 'Vui lòng nhập tên danh mục.'
        ]);

        try {
            // Đã bỏ // và thay bằng code thêm mới thực sự
            Category::create([
                'catename' => $request->catename,
                'slug'     => Str::slug($request->catename),
                'status'   => 1 // Mặc định hiển thị
            ]);

            return redirect()->route('admin.categories.index')->with('success', 'Thêm thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::where('cateid', $id)->firstOrFail();

        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::where('cateid', $id)->firstOrFail();

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'catename' => 'required|string|max:255|unique:categories,catename,' . $id . ',cateid',
        ], [
            'catename.unique' => 'Tên danh mục này đã bị trùng với một danh mục khác!',
        ]);

        try {
            // Tìm danh mục cần sửa và cập nhật dữ liệu mới
            $category = Category::where('cateid', $id)->firstOrFail();

            $category->update([
                'catename' => $request->catename,
                'slug'     => Str::slug($request->catename),
            ]);

            return redirect()->route('admin.categories.index')->with('success', 'Cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::where('cateid', $id)->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Xóa thành công!');
    }
}

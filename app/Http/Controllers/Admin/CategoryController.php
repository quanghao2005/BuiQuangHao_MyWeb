<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category; // Sử dụng Model Category thay cho Facade DB

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        // Sử dụng ORM Eloquent lấy danh sách loại sản phẩm và phân trang
        $list = Category::select('cateid', 'catename', 'slug', 'image', 'status')
            ->orderBy('catename', 'asc')
            ->paginate($limit); // Sử dụng paginate thay cho get()

        // Trả về view index và truyền biến $list sang giao diện
        return view('admin.categories.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Trả về view hiển thị form thêm mới loại sản phẩm 
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Sử dụng ORM Eloquent để thêm dữ liệu vào bảng categories
        Category::create([
            'catename'   => $request->catename,
            'slug'       => $request->slug,
            'image'      => $request->image ?? null, // Nếu có input ảnh thì lưu, không thì để null
            'status'     => $request->status ?? 1,   // Mặc định trạng thái là hiển thị (1)
        ]);

        // Sau khi thêm thành công, chuyển hướng về trang danh sách loại sản phẩm 
        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Sử dụng ORM Eloquent để lấy chi tiết
        $category = Category::where('cateid', $id)->firstOrFail();

        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Sử dụng ORM Eloquent để lấy dữ liệu đổ ra form
        $category = Category::where('cateid', $id)->firstOrFail();

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request data (Highly recommended)
        $request->validate([
            'catename' => 'required|string|max:255',
            // Thêm các rule khác nếu bảng categories của bạn có nhiều cột hơn
        ], [
            // Bạn có thể tuỳ chỉnh thông báo lỗi bằng tiếng Việt ở đây
            'catename.required' => 'Vui lòng nhập tên danh mục.',
            'catename.max'      => 'Tên danh mục không được vượt quá 255 ký tự.'
        ]);

        // Sử dụng ORM Eloquent để cập nhật dữ liệu
        Category::where('cateid', $id)->update([
            'catename'   => $request->input('catename'),
            // updated_at sẽ tự động được Eloquent cập nhật nếu bạn khai báo timestamps trong Model
        ]);

        // Chuyển hướng người dùng về trang danh sách và gửi kèm thông báo
        return redirect()->route('admin.categories.index')
            ->with('success', 'Đã cập nhật danh mục thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Sử dụng ORM Eloquent để xóa loại sản phẩm dựa trên khóa chính cateid
        Category::where('cateid', $id)->delete();

        // Sau khi xóa thành công, quay lại trang danh sách 
        return redirect()->route('admin.categories.index');
    }
}

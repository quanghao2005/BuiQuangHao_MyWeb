<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Cần import Facade DB để sử dụng Query Builder [cite: 88, 89]

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Sử dụng Query Builder lấy danh sách loại sản phẩm [cite: 93]
        $list = DB::table('categories')
            ->select('cateid', 'catename', 'slug', 'image', 'status') // Chỉ lấy các cột cần thiết 
            ->orderBy('catename', 'asc') // Sắp xếp tăng dần theo tên loại sản phẩm 
            ->get(); // Lấy tất cả dữ liệu thỏa mãn lưu vào biến $list [cite: 96]

        // Trả về view index và truyền biến $list sang giao diện [cite: 94, 96]
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
        // Sử dụng Query Builder để thêm dữ liệu vào bảng categories [cite: 198]
        DB::table('categories')->insert([
            'catename'   => $request->catename, // Lấy dữ liệu từ input 'catename' [cite: 201]
            'slug'       => $request->slug,     // Lấy dữ liệu từ input 'slug' [cite: 202]
            'image'      => $request->image ?? null, // Nếu có input ảnh thì lưu, không thì để null
            'status'     => 1,                  // Mặc định trạng thái là hiển thị (1)
            'created_at' => now(),              // Gán thời gian tạo hiện tại
            'updated_at' => now(),              // Gán thời gian cập nhật hiện tại
        ]);

        // Sau khi thêm thành công, chuyển hướng về trang danh sách loại sản phẩm [cite: 204, 206]
        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Hàm này dùng để xem chi tiết (chưa yêu cầu trong Lab 06, có thể để trống hoặc viết thêm)
        $category = DB::table('categories')->where('cateid', $id)->first();
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Hàm này dùng để hiển thị form sửa (để dành cho bài tìm hiểu câu G) [cite: 223]
        $category = DB::table('categories')->where('cateid', $id)->first();
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Hàm này xử lý cập nhật dữ liệu vào database (để dành cho bài tìm hiểu câu G) [cite: 223]
        DB::table('categories')
            ->where('cateid', $id)
            ->update([
                'catename'   => $request->catename,
                'slug'       => $request->slug,
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Xử lý xóa loại sản phẩm dựa trên khóa chính cateid [cite: 94, 214]
        DB::table('categories')->where('cateid', $id)->delete();

        // Sau khi xóa thành công, quay lại trang danh sách [cite: 204]
        return redirect()->route('admin.categories.index');
    }
}
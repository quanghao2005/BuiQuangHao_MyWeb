<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * Đáp ứng Câu C: Hiển thị danh sách người dùng
     */
    public function index()
    {
        // Kiểm tra xem bảng users có cột 'status' hay không
        $hasStatus = Schema::hasColumn('users', 'status');

        // SỬA: Đổi 'userid' thành 'id'
        $query = DB::table('users')->select('id', 'fullname', 'email', 'created_at');

        if ($hasStatus) {
            $query->addSelect('status');
        }

        // SỬA: orderBy dùng 'id' thay vì 'userid'
        $list = $query->orderBy('id', 'desc')->get();

        return view('admin.users.index', compact('list'));
    }

    public function destroy(string $id)
    {
        // SỬA: where dùng 'id' thay vì 'userid'
        DB::table('users')->where('id', $id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'Đã xóa thành công!');
    }


    // Các phương thức khác phục vụ cho việc mở rộng (Câu G)
    public function create()
    {
        return view('admin.users.create');
    }
    public function store(Request $request)
    { /* Logic lưu người dùng */
    }
    public function show(string $id)
    { /* Xem chi tiết */
    }
    public function edit(string $id)
    { /* Form sửa */
    }
    public function update(Request $request, string $id)
    { /* Logic sửa */
    }
}

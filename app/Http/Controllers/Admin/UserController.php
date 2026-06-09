<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Gọi Model User

class UserController extends Controller
{
    public function index($limit = 10)
    {
        // Lấy danh sách có phân trang
        $list = User::select('id', 'fullname', 'email', 'created_at')
            ->orderBy('id', 'desc')
            ->paginate($limit);

        return view('admin.users.index', compact('list'));
    }

    public function create()
    {
        // Trả về view form thêm mới
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // 1. Xác thực dữ liệu
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email', // Bắt buộc không được trùng email
            'password' => 'required|string|min:6',
        ], [
            'fullname.required' => 'Vui lòng nhập họ tên.',
            'email.required'    => 'Vui lòng nhập email.',
            'email.unique'      => 'Email này đã tồn tại trong hệ thống.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min'      => 'Mật khẩu phải chứa ít nhất 6 ký tự.'
        ]);

        // 2. Thêm vào database bằng Eloquent
        User::create([
            'fullname' => $request->fullname,
            'email'    => $request->email,
            'password' => bcrypt($request->password), // Phải mã hóa mật khẩu
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Thêm người dùng thành công!');
    }

    public function show(string $id)
    {
        // Dùng để xem chi tiết, hiện tại có thể để trống
    }

    public function edit(string $id)
    {
        // Lấy thông tin user hiện tại truyền ra form
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        // 1. Xác thực dữ liệu
        $request->validate([
            'fullname' => 'required|string|max:255',
            // Loại trừ email của chính user này khi check unique
            'email'    => 'required|email|unique:users,email,' . $id,
        ], [
            'fullname.required' => 'Vui lòng nhập họ tên.',
            'email.required'    => 'Vui lòng nhập email.',
            'email.unique'      => 'Email này đã tồn tại trong hệ thống.',
        ]);

        $data = [
            'fullname' => $request->fullname,
            'email'    => $request->email,
        ];

        // Nếu người dùng nhập mật khẩu mới thì mới cập nhật mật khẩu
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // 2. Cập nhật bằng Eloquent
        User::where('id', $id)->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật thông tin thành công!');
    }

    public function destroy(string $id)
    {
        // Xóa bằng Eloquent
        User::where('id', $id)->delete();

        return redirect()->route('admin.users.index')->with('success', 'Đã xóa người dùng thành công!');
    }
}

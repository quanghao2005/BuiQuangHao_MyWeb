<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UserRequest;
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

    public function store(UserRequest $request)
    {
        try {
            // 2. Thêm vào database bằng Eloquent
            User::create([
                'fullname' => $request->fullname,
                'email'    => $request->email,
                'password' => bcrypt($request->password), // Phải mã hóa mật khẩu
                'username' => 'user_' . time(), // Tạm tạo giá trị ngẫu nhiên do form chưa có
                'phone'    => '09' . rand(10000000, 99999999), // Tạm tạo số điện thoại ngẫu nhiên
                'gender'   => 1, // Mặc định (1: Nam)
                'role'     => 2, // Mặc định (2: Nhân viên)
                'status'   => 1, // Mặc định
            ]);

            return redirect()->route('admin.users.index')->with('success', 'Thêm người dùng thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Lỗi khi thêm người dùng: ' . $e->getMessage());
        }
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

    public function update(UserRequest $request, string $id)
    {
        try {
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
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Lỗi khi cập nhật người dùng: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        // Xóa bằng Eloquent
        User::where('id', $id)->delete();

        return redirect()->route('admin.users.index')->with('success', 'Đã xóa người dùng thành công!');
    }
}

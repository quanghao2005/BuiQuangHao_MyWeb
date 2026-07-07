<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Hiển thị trang đăng nhập
    public function login()
    {
        // Kiểm tra đã lưu đăng nhập chưa thì chuyển đến Dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    // Xử lý đăng nhập
    public function postLogin(Request $request)
    {
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'username' => 'Tên đăng nhập',
                'password' => 'Mật khẩu',
            ]
        );

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()
                ->with('message', 'Username không tồn tại')
                ->withInput();
        }

        $check = Hash::check($request->password, $user->password);
        
        if (!$check) {
            return back()->with('message', 'Mật khẩu không đúng')->withInput();
        }

        $remember = $request->has('remember') ? true : false;
        Auth::login($user, $remember);

        return redirect()->intended(route('admin.dashboard'));
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    // Hiển thị trang Quên mật khẩu
    public function forgotPassword()
    {
        return view('admin.auth.forgotpassword');
    }

    // Xử lý quên mật khẩu
    public function postForgotPassword(Request $request) 
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email'
        ], [
            'required' => ':attribute không được để trống.',
            'email' => ':attribute không đúng định dạng.'
        ], [
            'username' => 'Tên đăng nhập',
            'email' => 'Email',
        ]);

        $user = User::where('username', $request->username)
                    ->where('email', $request->email)
                    ->first();

        if (!$user) {
            return back()->with('error', 'Thông tin không khớp với tài khoản nào trong hệ thống.')->withInput();
        }

        // Đặt lại mật khẩu mặc định (ví dụ: 123456)
        $user->password = Hash::make('123456');
        $user->save();

        return redirect()->route('admin.login')->with('success', 'Đã đặt lại mật khẩu thành công. Mật khẩu mới của bạn là: 123456');
    }

    // Hiển thị trang Đổi mật khẩu
    public function changePassword()
    {
        return view('admin.auth.changepassword');
    }

    // Xử lý Đổi mật khẩu
    public function postChangePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|different:old_password',
            'confirm_password' => 'required|same:new_password',
        ], [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải có ít nhất :min ký tự.',
            'different' => ':attribute phải khác mật khẩu cũ.',
            'same' => 'Xác nhận mật khẩu không khớp.'
        ], [
            'old_password' => 'Mật khẩu cũ',
            'new_password' => 'Mật khẩu mới',
            'confirm_password' => 'Xác nhận mật khẩu',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Mật khẩu cũ không đúng.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
}

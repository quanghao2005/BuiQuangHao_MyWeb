<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    // Hiển thị trang đăng nhập
    public function login()
    {
        // Kiểm tra đã lưu đăng nhập chưa thì chuyển đến Dashboard
        if (Auth::check()) {
            if (Auth::user()->role == 1) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('home');
            }
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

        $user = User::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if (!$user) {
            return back()
                ->withErrors(['username' => 'Tên đăng nhập hoặc email không tồn tại.'])
                ->withInput();
        }

        $check = Hash::check($request->password, $user->password);

        if (!$check) {
            return back()
                ->withErrors(['password' => 'Mật khẩu không đúng.'])
                ->withInput();
        }

        $remember = $request->has('remember') ? true : false;
        Auth::login($user, $remember);

        // Redirect based on role
        if ($user->role == 1) {
            return redirect()->intended(route('admin.dashboard'));
        } else {
            return redirect()->intended(route('home'));
        }
    }

    // Hiển thị trang Đăng ký
    public function register()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 1) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('home');
            }
        }
        return view('admin.auth.register');
    }

    // Xử lý Đăng ký
    public function postRegister(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone'    => 'required|string|max:15|unique:users',
            'gender'   => 'required|in:0,1,2',
        ], [
            'required' => ':attribute không được để trống.',
            'unique'   => ':attribute đã được sử dụng.',
            'min'      => ':attribute phải có ít nhất :min ký tự.',
            'email'    => 'Email không đúng định dạng.',
            'in'       => ':attribute không hợp lệ.',
        ], [
            'fullname' => 'Họ và tên',
            'username' => 'Tên đăng nhập',
            'email'    => 'Địa chỉ email',
            'password' => 'Mật khẩu',
            'phone'    => 'Số điện thoại',
            'gender'   => 'Giới tính',
        ]);

        $user = User::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'gender'   => $request->gender,
            'role'     => 2, // Đăng ký mới mặc định role 2
            'status'   => 1, // Kích hoạt ngay
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký tài khoản thành công! Vui lòng đăng nhập.');
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // Hiển thị trang Quên mật khẩu
    public function forgotPassword()
    {
        return view('admin.auth.forgotpassword');
    }

    // Xử lý quên mật khẩu
    public function postForgotPassword(Request $request)
    {
        // validate - kiểm tra dữ liệu đầu vào
        $request->validate(
            ['email' => 'required|email'],
            [
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không đúng định dạng',
            ]
        );

        // Kiểm tra email tồn tại
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()
                ->with('error', 'Email không tồn tại')
                ->withInput();
        }

        // Tạo mã OTP 6 số ngẫu nhiên
        $otp = rand(100000, 999999);

        // Lưu vào Session
        $request->session()->put('reset_email', $request->email);
        $request->session()->put('reset_otp', $otp);

        // Nội dung email
        $html = '
        <div style="font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; max-width: 600px; margin: 0 auto; padding: 30px; border-radius: 12px; background-color: #ffffff; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #eaeaea;">
            <div style="text-align: center; margin-bottom: 25px;">
                <h1 style="color: #2c3e50; margin: 0; font-size: 24px;">Yêu Cầu Đặt Lại Mật Khẩu</h1>
            </div>
            <p style="color: #555; font-size: 16px; line-height: 1.6; margin-bottom: 20px;">Xin chào,</p>
            <p style="color: #555; font-size: 16px; line-height: 1.6; margin-bottom: 25px;">Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Vui lòng sử dụng mã xác nhận (OTP) gồm 6 chữ số dưới đây để tiếp tục:</p>
            <div style="text-align: center; margin: 35px 0;">
                <span style="display: inline-block; padding: 15px 40px; font-size: 36px; font-weight: bold; color: #ffffff; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 10px; letter-spacing: 8px; box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);">' . $otp . '</span>
            </div>
            <p style="color: #777; font-size: 14px; line-height: 1.6; text-align: center; margin-bottom: 30px;">
                Mã xác nhận này chỉ có hiệu lực trong phiên làm việc hiện tại.<br>
                Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này và bảo mật tài khoản của bạn.
            </p>
            <hr style="border: none; border-top: 1px solid #eeeeee; margin: 30px 0;">
            <p style="color: #a0a0a0; font-size: 12px; text-align: center; margin: 0;">
                &copy; ' . date('Y') . ' Hệ thống quản trị. Tất cả các quyền được bảo lưu.
            </p>
        </div>';

        // Gửi email
        Mail::html($html, function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Mã OTP đặt lại mật khẩu');
        });

        // Điều hướng sang trang nhập OTP
        return redirect()->route('forgotpass.otp')->with('success', 'Mã xác nhận 6 số đã được gửi vào email của bạn.');
    }

    // Hiển thị form nhập OTP
    public function otpForm(Request $request)
    {
        if (!$request->session()->has('reset_email')) {
            return redirect()->route('forgotpass')->with('error', 'Vui lòng nhập email trước.');
        }
        return view('admin.auth.otp');
    }

    // Xử lý OTP
    public function postOtp(Request $request)
    {
        $request->validate(
            ['otp' => 'required|numeric'],
            ['otp.required' => 'Vui lòng nhập mã OTP', 'otp.numeric' => 'Mã OTP phải là số']
        );

        $sessionOtp = $request->session()->get('reset_otp');

        if ($request->otp == $sessionOtp) {
            $request->session()->put('reset_otp_verified', true);
            return redirect()->route('forgotpass.reset')->with('success', 'Mã xác nhận chính xác. Vui lòng nhập mật khẩu mới.');
        }

        return back()->with('error', 'Mã OTP không đúng. Vui lòng thử lại.');
    }

    // Hiển thị form nhập mật khẩu mới
    public function resetPasswordForm(Request $request)
    {
        if (!$request->session()->has('reset_otp_verified')) {
            return redirect()->route('forgotpass.otp')->with('error', 'Vui lòng xác minh mã OTP trước.');
        }
        return view('admin.auth.reset_password');
    }

    // Xử lý lưu mật khẩu mới
    public function postResetPassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ], [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải có ít nhất :min ký tự.',
            'same' => 'Xác nhận mật khẩu không khớp.'
        ], [
            'new_password' => 'Mật khẩu mới',
            'confirm_password' => 'Xác nhận mật khẩu',
        ]);

        $email = $request->session()->get('reset_email');
        $user = User::where('email', $email)->first();

        if ($user) {
            $user->password = Hash::make($request->new_password);
            $user->save();
        }

        // Xóa session
        $request->session()->forget(['reset_email', 'reset_otp', 'reset_otp_verified']);

        return redirect()->route('login')->with('success', 'Đổi mật khẩu thành công! Vui lòng đăng nhập bằng mật khẩu mới.');
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

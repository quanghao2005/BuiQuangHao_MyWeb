<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Order;

class ProfileController extends Controller
{
    // Hiển thị trang Profile
    public function index()
    {
        $user = Auth::user();
        return view('client.profile.index', compact('user'));
    }

    // Hiển thị lịch sử mua hàng
    public function orders()
    {
        $user = Auth::user();
        
        // Lấy các đơn hàng dựa trên email của user hiện tại hoặc user_id
        $orders = Order::with('items.product')
            ->whereHas('customer', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('email', $user->email);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('client.profile.orders', compact('user', 'orders'));
    }

    // Cập nhật thông tin cá nhân
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'fullname' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|integer|in:0,1',
            'birthday' => 'nullable|date',
        ]);

        $user->fullname = $request->fullname;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->birthday = $request->birthday;
        $user->save();

        return redirect()->back()->with('success', 'Cập nhật thông tin cá nhân thành công!');
    }

    // Cập nhật ảnh đại diện
    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $imageName = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('uploads/avatars'), $imageName);
            // Xóa ảnh cũ nếu có
            if ($user->avatar && file_exists(public_path('uploads/avatars/' . $user->avatar))) {
                unlink(public_path('uploads/avatars/' . $user->avatar));
            }
            $user->avatar = $imageName;
            $user->save();
        }

        return redirect()->back()->with('success', 'Cập nhật ảnh đại diện thành công!');
    }

    // Đổi mật khẩu
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Đổi mật khẩu thành công!');
    }
}

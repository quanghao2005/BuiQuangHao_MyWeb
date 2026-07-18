<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdated;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng
     */
    public function index()
    {
        // Lấy tất cả đơn hàng, sắp xếp mới nhất lên trước
        $orders = Order::with('customer')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function show(string $id)
    {
        $order = Order::with(['customer', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Hiển thị chi tiết đơn hàng (dạng Modal Quick View)
     */
    public function showModal(string $id)
    {
        $order = Order::with(['customer', 'items.product'])->findOrFail($id);
        return view('admin.orders._modal_details', compact('order'))->render();
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:0,1,2,3', // 0: Chờ xử lý, 1: Đang giao, 2: Đã giao, 3: Đã hủy
        ]);

        $order = Order::with('customer')->findOrFail($id);
        
        if (in_array($order->status, [2, 3])) {
            return redirect()->back()->with('error', 'Đơn hàng đã chốt (Hoàn thành/Hủy), không thể thay đổi trạng thái!');
        }

        // Chỉ gửi thông báo nếu trạng thái thực sự thay đổi
        $statusChanged = $order->status != $request->status;
        
        $order->status = $request->status;
        $order->save();

        if ($statusChanged && $order->customer && $order->customer->email) {
            $customer = $order->customer;
            // Gửi email chạy ngầm để không làm chậm giao diện admin
            defer(function () use ($order, $customer) {
                try {
                    Mail::to($customer->email)->send(new OrderStatusUpdated($order, $customer));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Lỗi gửi email cập nhật trạng thái: ' . $e->getMessage());
                }
            });
        }

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công!');
    }
}

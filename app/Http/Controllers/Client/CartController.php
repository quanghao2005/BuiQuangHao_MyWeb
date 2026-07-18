<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\OrderPlaced;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('client.cart.index', compact('cart', 'total'));
    }

    // Thêm vào giỏ hàng
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $price = $product->pricediscount > 0 ? $product->pricediscount : $product->price;
            $cart[$id] = [
                'productid' => $product->id,
                'proname' => $product->productname,
                'quantity' => 1,
                'price' => $price,
                'image' => $product->image
            ];
        }

        Session::put('cart', $cart);
        return response()->json(['success' => true, 'message' => 'Đã thêm vào giỏ hàng', 'cart_count' => count($cart)]);
    }

    // Cập nhật số lượng
    public function update(Request $request)
    {
        $id = $request->id;
        $quantity = $request->quantity;
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            if ($quantity > 0) {
                $cart[$id]['quantity'] = $quantity;
            } else {
                unset($cart[$id]);
            }
            Session::put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cập nhật giỏ hàng thành công!');
    }

    // Cập nhật số lượng qua Ajax (Real-time)
    public function updateAjax(Request $request)
    {
        $id = $request->id;
        $quantity = $request->quantity;
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            if ($quantity > 0) {
                $cart[$id]['quantity'] = $quantity;
            } else {
                unset($cart[$id]);
            }
            Session::put('cart', $cart);
            
            $itemTotal = isset($cart[$id]) ? $cart[$id]['price'] * $cart[$id]['quantity'] : 0;
            return response()->json([
                'success' => true, 
                'item_total' => $itemTotal,
                'cart_count' => count($cart)
            ]);
        }
        return response()->json(['success' => false], 400);
    }

    // Xóa khỏi giỏ hàng
    public function remove($id)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng');
    }

    // Trang checkout
    public function checkout(Request $request)
    {
        $cart = Session::get('cart', []);
        
        // Nếu submit từ giỏ hàng (chọn các item cụ thể)
        if ($request->isMethod('post') && $request->has('selected_items')) {
            $selectedIds = $request->input('selected_items');
            Session::put('checkout_items', $selectedIds); // Lưu vào session
        } else {
            // Lấy từ session hoặc toàn bộ giỏ hàng
            $selectedIds = Session::get('checkout_items', array_keys($cart));
        }

        $checkoutCart = [];
        foreach ($selectedIds as $id) {
            if (isset($cart[$id])) {
                $checkoutCart[$id] = $cart[$id];
            }
        }

        if (count($checkoutCart) == 0) {
            return redirect()->route('cart.index')->with('error', 'Bạn chưa chọn sản phẩm nào để thanh toán!');
        }

        $total = 0;
        foreach ($checkoutCart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('client.cart.checkout', ['cart' => $checkoutCart, 'total' => $total]);
    }

    // Xử lý lưu đơn hàng
    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'email' => 'nullable|email'
        ]);

        $cart = Session::get('cart', []);
        $selectedIds = Session::get('checkout_items', array_keys($cart));
        
        $checkoutCart = [];
        foreach ($selectedIds as $id) {
            if (isset($cart[$id])) {
                $checkoutCart[$id] = $cart[$id];
            }
        }

        if (count($checkoutCart) == 0) {
            return redirect()->route('home')->with('error', 'Giỏ hàng trống');
        }

        DB::beginTransaction();
        try {
            // 1. Lưu khách hàng
            $customer = Customer::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address
            ]);

            // 2. Tính tổng tiền
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // 3. Lưu Order
            $order = Order::create([
                'customer_id' => $customer->id,
                'total_amount' => $total,
                'status' => 0, // 0: Chờ xử lý
                'note' => $request->note
            ]);

            // 4. Lưu Order Items
            foreach ($checkoutCart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['productid'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }

            DB::commit();
            
            // Gửi email xác nhận (chạy ngầm sau khi trả về response để không làm chậm checkout)
            if ($customer->email) {
                defer(function () use ($customer, $order, $checkoutCart) {
                    try {
                        Mail::to($customer->email)->send(new OrderPlaced($order, $customer, $checkoutCart));
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('Lỗi gửi email: ' . $e->getMessage());
                    }
                });
            }

            // Xóa các sản phẩm đã thanh toán khỏi giỏ hàng
            foreach ($selectedIds as $id) {
                unset($cart[$id]);
            }
            Session::put('cart', $cart);
            Session::forget('checkout_items');

            return redirect()->route('home')->with('success', 'Đặt hàng thành công! Chúng tôi sẽ liên hệ với bạn sớm nhất.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra, vui lòng thử lại: ' . $e->getMessage());
        }
    }
}

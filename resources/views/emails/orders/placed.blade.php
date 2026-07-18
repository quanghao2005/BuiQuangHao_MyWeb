<x-mail::message>
# Xin chào {{ $customer->name }},

Cảm ơn bạn đã tin tưởng và mua sắm tại **TechStore**. Đơn hàng của bạn đã được ghi nhận trên hệ thống và đang trong quá trình chờ xử lý.

<x-mail::panel>
**Mã đơn hàng:** #{{ $order->id }}  
**Ngày đặt:** {{ $order->created_at->format('d/m/Y H:i') }}  
**Người nhận:** {{ $customer->name }} ({{ $customer->phone }})  
**Địa chỉ:** {{ $customer->address }}
</x-mail::panel>

### Chi tiết sản phẩm

<x-mail::table>
| Sản phẩm | SL | Đơn giá | Thành tiền |
|:---------|:--:|:-------:|----------:|
@foreach($checkoutCart as $item)
| {{ $item['proname'] }} | {{ $item['quantity'] }} | {{ number_format($item['price'], 0, ',', '.') }}đ | {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ |
@endforeach
</x-mail::table>

## Tổng thanh toán: {{ number_format($order->total_amount, 0, ',', '.') }}đ

<p style="text-align: center; color: #3b82f6; font-weight: bold; margin: 20px 0;">Cảm ơn bạn đã lựa chọn TechStore!</p>
Nếu bạn có thắc mắc, vui lòng liên hệ hotline: **1900 6868**

Trân trọng,<br>
{{ config('app.name') }}
</x-mail::message>

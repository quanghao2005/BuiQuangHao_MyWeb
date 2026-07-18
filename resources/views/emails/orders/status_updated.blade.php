<x-mail::message>
# Xin chào {{ $customer->name }},

Đơn hàng **#{{ $order->id }}** của bạn vừa được cập nhật trạng thái mới trên hệ thống.

<x-mail::panel>
**Trạng thái hiện tại:** <span style="color: {{ $statusColor }}; font-weight: bold;">{{ $statusText }}</span>  
**Ngày cập nhật:** {{ now()->format('d/m/Y H:i') }}
</x-mail::panel>

@if($order->status == 1)
Đơn hàng của bạn đang được bàn giao cho đơn vị vận chuyển và sẽ sớm đến tay bạn. Vui lòng chú ý điện thoại để shipper có thể liên lạc nhé!
@elseif($order->status == 2)
Đơn hàng đã được giao thành công. Chúc bạn có trải nghiệm tuyệt vời với sản phẩm! Nếu có bất kỳ vấn đề gì, đừng ngần ngại liên hệ với chúng tôi.
@elseif($order->status == 3)
Rất tiếc, đơn hàng của bạn đã bị hủy. Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ với chúng tôi để được hỗ trợ.
@endif

<p style="text-align: center; color: #3b82f6; font-weight: bold; margin: 20px 0;">Cảm ơn bạn đã luôn đồng hành cùng TechStore!</p>

Nếu cần hỗ trợ thêm, vui lòng liên hệ hotline: **1900 6868**

Trân trọng,<br>
{{ config('app.name') }}
</x-mail::message>

@forelse($recentOrders as $order)
<tr>
    <td><span class="fw-bold">#{{ $order->id }}</span></td>
    <td>
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-2" style="width: 35px; height: 35px;">
                {{ substr($order->customer->name ?? '?', 0, 1) }}
            </div>
            <div>
                <div class="fw-semibold">{{ $order->customer->name ?? 'Không rõ' }}</div>
                <div class="text-muted small">{{ $order->customer->phone ?? '' }}</div>
            </div>
        </div>
    </td>
    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
    <td class="fw-bold text-danger">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
    <td>
        @if($order->status == 0)
            <span class="badge bg-warning text-dark">Chờ xử lý</span>
        @elseif($order->status == 1)
            <span class="badge bg-info text-dark">Đang giao</span>
        @elseif($order->status == 2)
            <span class="badge bg-success">Đã giao</span>
        @else
            <span class="badge bg-danger">Đã hủy</span>
        @endif
    </td>
    <td class="text-end">
        <button class="btn btn-sm btn-light rounded-circle view-order-btn" data-bs-toggle="modal" data-bs-target="#quickViewOrderModal" data-id="{{ $order->id }}" title="Xem chi tiết">
            <i class="bi bi-eye text-primary"></i>
        </button>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center py-4 text-muted">
        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
        Chưa có đơn hàng nào
    </td>
</tr>
@endforelse

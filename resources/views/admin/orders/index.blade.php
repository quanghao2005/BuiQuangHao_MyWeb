@extends('admin.layouts.admin')
@section('title', 'Quản lý Đơn hàng')

@section('content')
<div class="card shadow border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h4 class="m-0 font-weight-bold text-primary"><i class="bi bi-cart-check me-2"></i>Danh sách Đơn hàng</h4>
    </div>
    
    <div class="card-body">
        <x-admin.alert></x-admin.alert>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
                        <th width="15%">Mã ĐH</th>
                        <th width="20%">Khách hàng</th>
                        <th width="15%">Tổng tiền</th>
                        <th width="15%">Ngày đặt</th>
                        <th width="15%">Trạng thái</th>
                        <th width="15%" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $key => $order)
                        <tr>
                            <td>{{ $orders->firstItem() + $key }}</td>
                            <td class="fw-bold text-primary">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <strong>{{ $order->customer->name ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $order->customer->phone ?? 'N/A' }}</small>
                            </td>
                            <td class="text-danger fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }} đ</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($order->status == 0)
                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Chờ xử lý</span>
                                @elseif($order->status == 1)
                                    <span class="badge bg-info text-dark"><i class="bi bi-truck me-1"></i>Đang giao hàng</span>
                                @elseif($order->status == 2)
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Đã giao xong</span>
                                @else
                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Đã hủy</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary" title="Xem chi tiết">
                                    <i class="bi bi-eye"></i> Xem
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Chưa có đơn hàng nào trong hệ thống!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection

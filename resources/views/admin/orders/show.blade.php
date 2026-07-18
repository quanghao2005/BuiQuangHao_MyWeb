@extends('admin.layouts.admin')
@section('title', 'Chi tiết Đơn hàng')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Quay lại danh sách
    </a>
</div>

<x-admin.alert></x-admin.alert>

<div class="row">
    <!-- Thông tin đơn hàng & Khách hàng -->
    <div class="col-lg-4">
        <div class="card shadow border-0 mb-4">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="m-0 font-weight-bold"><i class="bi bi-person-lines-fill me-2"></i>Thông tin Khách hàng</h5>
            </div>
            <div class="card-body">
                <p><strong>Họ và tên:</strong> {{ $order->customer->name ?? 'N/A' }}</p>
                <p><strong>Số điện thoại:</strong> {{ $order->customer->phone ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $order->customer->email ?? 'Không có' }}</p>
                <p><strong>Địa chỉ giao hàng:</strong> {{ $order->customer->address ?? 'N/A' }}</p>
                <hr>
                <p><strong>Ghi chú đơn hàng:</strong></p>
                <div class="p-2 bg-light border rounded">
                    {{ $order->note ?? 'Không có ghi chú' }}
                </div>
            </div>
        </div>

        <!-- Cập nhật trạng thái -->
        <div class="card shadow border-0 mb-4">
            <div class="card-header bg-success text-white py-3">
                <h5 class="m-0 font-weight-bold"><i class="bi bi-arrow-repeat me-2"></i>Cập nhật Trạng thái</h5>
            </div>
            <div class="card-body">
                @if($order->status == 2 || $order->status == 3)
                    <div class="alert alert-secondary mb-0">
                        <i class="bi bi-lock-fill me-2"></i>Đơn hàng đã chốt (Hoàn thành / Hủy) nên không thể thay đổi trạng thái.
                    </div>
                @else
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Trạng thái hiện tại:</label>
                        <select name="status" class="form-select">
                            <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Đang giao hàng</option>
                            <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>Đã giao xong (Hoàn thành)</option>
                            <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100"><i class="bi bi-save me-2"></i>Cập nhật</button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Chi tiết sản phẩm mua -->
    <div class="col-lg-8">
        <div class="card shadow border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-receipt me-2"></i>Chi tiết hóa đơn #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                </h5>
                <span class="text-muted">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</span>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Sản phẩm</th>
                                <th class="text-center">Đơn giá</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end pe-4">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/products/' . $item->product->image) }}" alt="Product" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('images/no-image.jpg') }}" alt="No image" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            @endif
                                            <span class="fw-bold">{{ $item->product->productname ?? 'Sản phẩm đã bị xóa' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                    <td class="text-center">x{{ $item->quantity }}</td>
                                    <td class="text-end pe-4 fw-bold text-primary">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                                <td class="text-end pe-4 fw-bold text-danger fs-5">{{ number_format($order->total_amount, 0, ',', '.') }} đ</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

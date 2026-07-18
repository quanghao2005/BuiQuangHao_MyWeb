<div class="container-fluid p-4">
    <div class="row">
        <!-- Thông tin khách hàng -->
        <div class="col-md-5">
            <h6 class="fw-bold text-primary mb-3"><i class="bi bi-person-lines-fill me-2"></i>Thông tin Khách hàng</h6>
            <div class="bg-light p-3 rounded">
                <p class="mb-2"><strong>Họ và tên:</strong> {{ $order->customer->name ?? 'N/A' }}</p>
                <p class="mb-2"><strong>Điện thoại:</strong> {{ $order->customer->phone ?? 'N/A' }}</p>
                <p class="mb-2"><strong>Email:</strong> {{ $order->customer->email ?? 'Không có' }}</p>
                <p class="mb-2"><strong>Địa chỉ:</strong> {{ $order->customer->address ?? 'N/A' }}</p>
                @if($order->note)
                    <hr>
                    <p class="mb-1"><strong>Ghi chú:</strong></p>
                    <p class="text-muted small mb-0">{{ $order->note }}</p>
                @endif
            </div>

            <h6 class="fw-bold text-success mt-4 mb-3"><i class="bi bi-info-circle me-2"></i>Trạng thái hiện tại</h6>
            <div class="p-3 border rounded text-center">
                @if($order->status == 0)
                    <span class="badge bg-warning text-dark fs-6 w-100 py-2"><i class="bi bi-hourglass-split me-1"></i>Chờ xử lý</span>
                @elseif($order->status == 1)
                    <span class="badge bg-info text-dark fs-6 w-100 py-2"><i class="bi bi-truck me-1"></i>Đang giao hàng</span>
                @elseif($order->status == 2)
                    <span class="badge bg-success fs-6 w-100 py-2"><i class="bi bi-check-circle me-1"></i>Đã giao xong</span>
                @else
                    <span class="badge bg-danger fs-6 w-100 py-2"><i class="bi bi-x-circle me-1"></i>Đã hủy</span>
                @endif
            </div>
        </div>

        <!-- Chi tiết sản phẩm -->
        <div class="col-md-7">
            <h6 class="fw-bold text-primary mb-3"><i class="bi bi-box-seam me-2"></i>Sản phẩm đã đặt (#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }})</h6>
            
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Sản phẩm</th>
                            <th class="text-center">Đơn giá</th>
                            <th class="text-center">SL</th>
                            <th class="text-end">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset('storage/products/' . $item->product->image) }}" alt="Product" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('images/no-image.jpg') }}" alt="No image" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        @endif
                                        <span class="small fw-semibold text-truncate" style="max-width: 150px;" title="{{ $item->product->productname ?? 'N/A' }}">
                                            {{ $item->product->productname ?? 'Đã xóa' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="text-center small">{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                <td class="text-center small">x{{ $item->quantity }}</td>
                                <td class="text-end small fw-bold text-primary">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                            <td class="text-end fw-bold text-danger">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@extends('client.layouts.app')
@section('title', 'Thanh toán - TechStore')

@section('content')
    <div class="mb-4">
        <h3 class="fw-bold border-start border-4 border-primary ps-2">Xác nhận thanh toán</h3>
    </div>

    <form action="{{ route('checkout.post') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-7">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-geo-alt me-2 text-primary"></i>Thông tin giao hàng</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required placeholder="Nhập họ và tên người nhận">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="phone" name="phone" required placeholder="Ví dụ: 0987654321">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold">Địa chỉ Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Để nhận thông tin đơn hàng">
                            </div>

                            <div class="col-md-12">
                                <label for="address" class="form-label fw-bold">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address" name="address" required placeholder="Nhập số nhà, tên đường, phường/xã, quận/huyện...">
                            </div>

                            <div class="col-md-12">
                                <label for="note" class="form-label fw-bold">Ghi chú đơn hàng (Tùy chọn)</label>
                                <textarea class="form-control" id="note" name="note" rows="3" placeholder="Ghi chú về thời gian hoặc địa điểm giao hàng..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-bag-check me-2 text-primary"></i>Tóm tắt đơn hàng</h5>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-group list-group-flush mb-3">
                            @foreach($cart as $item)
                            <li class="list-group-item d-flex justify-content-between lh-sm px-0 py-3">
                                <div>
                                    <h6 class="my-0 text-truncate" style="max-width: 200px;">{{ $item['proname'] }}</h6>
                                    <small class="text-muted">Số lượng: x{{ $item['quantity'] }}</small>
                                </div>
                                <span class="text-danger fw-bold">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</span>
                            </li>
                            @endforeach
                        </ul>

                        <div class="d-flex justify-content-between mb-2 mt-4 border-top pt-3">
                            <span>Tạm tính</span>
                            <strong>{{ number_format($total, 0, ',', '.') }}đ</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Phí vận chuyển</span>
                            <strong class="text-success">Miễn phí</strong>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-4 border-top pt-3">
                            <span class="fs-5 fw-bold">Tổng thanh toán</span>
                            <span class="fs-4 fw-bold text-primary">{{ number_format($total, 0, ',', '.') }}đ</span>
                        </div>
                        
                        <div class="alert alert-info py-2" role="alert">
                            <i class="bi bi-info-circle me-1"></i> Thanh toán khi nhận hàng (COD).
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold rounded-pill">ĐẶT HÀNG NGAY</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

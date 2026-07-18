@extends('client.layouts.app')
@section('title', 'Lịch sử mua hàng - TechStore')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    @if($user->avatar)
                        <img src="{{ asset('uploads/avatars/' . $user->avatar) }}" alt="{{ $user->fullname }}" class="rounded-circle mb-3 border shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-person-fill fs-1"></i>
                        </div>
                    @endif
                    <h5 class="fw-bold mb-1">{{ $user->fullname }}</h5>
                    <p class="text-muted small mb-0">{{ $user->email }}</p>

                    <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        <input type="file" name="avatar" class="form-control form-control-sm mb-2" accept="image/*" required>
                        <button type="submit" class="btn btn-sm btn-outline-primary w-100"><i class="bi bi-camera me-1"></i> Cập nhật ảnh</button>
                    </form>
                </div>
                <div class="list-group list-group-flush border-top">
                    <a href="{{ route('profile.index') }}" class="list-group-item list-group-item-action border-0 py-3">
                        <i class="bi bi-person-badge me-2"></i> Thông tin cá nhân
                    </a>
                    <a href="{{ route('profile.orders') }}" class="list-group-item list-group-item-action active border-0 py-3">
                        <i class="bi bi-bag-check me-2"></i> Lịch sử mua hàng
                    </a>
                    <a href="{{ route('profile.index') }}#security" class="list-group-item list-group-item-action border-0 py-3">
                        <i class="bi bi-shield-lock me-2"></i> Đổi mật khẩu
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="list-group-item list-group-item-action border-0 py-3 text-danger w-100 text-start">
                            <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <h4 class="fw-bold mb-4 border-bottom pb-3">Lịch sử mua hàng</h4>
                    
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Ngày đặt</th>
                                        <th>Sản phẩm</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="fw-bold">#{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <ul class="list-unstyled mb-0 small">
                                                    @foreach($order->items as $item)
                                                        <li class="text-truncate" style="max-width: 250px;">
                                                            <span class="text-primary fw-semibold">{{ $item->quantity }}x</span> 
                                                            {{ $item->product->productname ?? 'Sản phẩm đã xóa' }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td class="text-danger fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                                            <td>
                                                @if($order->status == 1)
                                                    <span class="badge bg-info">Đang giao</span>
                                                @elseif($order->status == 2)
                                                    <span class="badge bg-success">Đã giao</span>
                                                @elseif($order->status == 3)
                                                    <span class="badge bg-danger">Đã hủy</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Phân trang -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-box-seam text-muted opacity-25" style="font-size: 5rem;"></i>
                            <h5 class="text-muted mt-3">Bạn chưa có đơn hàng nào</h5>
                            <a href="{{ route('home') }}" class="btn btn-primary mt-3 px-4 rounded-pill">Mua sắm ngay</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

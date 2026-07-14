@extends('client.layouts.app')
@section('title', 'Giỏ hàng của bạn - TechStore')

@section('content')
    <div class="mb-4">
        <h3 class="fw-bold border-start border-4 border-primary ps-2">Giỏ hàng của bạn</h3>
    </div>

    @if(count($cart) > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="ps-4">Sản phẩm</th>
                                        <th scope="col" class="text-center">Đơn giá</th>
                                        <th scope="col" class="text-center" style="width: 150px;">Số lượng</th>
                                        <th scope="col" class="text-center">Thành tiền</th>
                                        <th scope="col" class="text-end pe-4">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $id => $item)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    @if ($item['image'])
                                                        <img src="{{ asset('storage/products/' . $item['image']) }}" alt="{{ $item['proname'] }}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('images/no-image.jpg') }}" alt="No Image" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <a href="{{ route('products.show', \App\Models\Product::find($id)->slug ?? '') }}" class="text-dark fw-bold text-decoration-none d-block text-truncate" style="max-width: 200px;">{{ $item['proname'] }}</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center text-danger fw-bold">
                                                {{ number_format($item['price'], 0, ',', '.') }}đ
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('cart.update') }}" method="POST" class="d-flex justify-content-center align-items-center">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $id }}">
                                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm text-center w-50" onchange="this.form.submit()">
                                                </form>
                                            </td>
                                            <td class="text-center text-primary fw-bold">
                                                {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="{{ route('cart.remove', $id) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <a href="{{ route('home') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-2"></i>Tiếp tục mua sắm</a>
            </div>

            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card shadow-sm border-0 bg-primary text-white">
                    <div class="card-body p-4">
                        <h4 class="card-title fw-bold border-bottom pb-3 mb-4 border-light">Tổng giỏ hàng</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tạm tính:</span>
                            <span class="fw-bold">{{ number_format($total, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Phí vận chuyển:</span>
                            <span class="fw-bold">Miễn phí</span>
                        </div>
                        <hr class="border-light">
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fs-5">Tổng cộng:</span>
                            <span class="fs-4 fw-bold">{{ number_format($total, 0, ',', '.') }}đ</span>
                        </div>
                        
                        <a href="{{ route('checkout') }}" class="btn btn-light btn-lg w-100 fw-bold rounded-pill text-primary">TIẾN HÀNH THANH TOÁN</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <img src="{{ asset('images/empty-cart.png') }}" alt="Empty Cart" style="width: 200px; opacity: 0.5">
            <h4 class="text-muted mt-4">Giỏ hàng của bạn đang trống</h4>
            <p class="text-muted">Chưa có sản phẩm nào trong giỏ hàng.</p>
            <a href="{{ route('home') }}" class="btn btn-primary btn-lg mt-3 px-5 rounded-pill"><i class="bi bi-cart me-2"></i>Mua sắm ngay</a>
        </div>
    @endif
@endsection

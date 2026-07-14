@extends('client.layouts.app')
@section('title', 'Trang chủ - TechStore')

@section('content')
    <!-- Banner -->
    <div class="p-5 mb-4 bg-primary text-white rounded-3 shadow" style="background: linear-gradient(135deg, #4F46E5, #3B82F6);">
        <div class="container-fluid py-3">
            <h1 class="display-5 fw-bold">Mua sắm công nghệ thông minh</h1>
            <p class="col-md-8 fs-4">Chào mừng bạn đến với TechStore - Nơi cung cấp các thiết bị điện tử chính hãng với giá tốt nhất và dịch vụ chăm sóc khách hàng hàng đầu.</p>
            <a href="#" class="btn btn-light btn-lg fw-bold px-4 rounded-pill">Khám phá ngay</a>
        </div>
    </div>

    <!-- Khu vực 1: Sản phẩm mới nhất -->
    <div class="mt-5">
        <h3 class="mb-4 fw-bold border-start border-4 border-primary ps-2">Sản phẩm mới nhất</h3>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($newProducts as $product)
                <div class="col">
                    <x-client.product :product="$product" />
                </div>
            @endforeach
        </div>
    </div>

    <!-- Khu vực 2: Sản phẩm giảm giá -->
    @if(count($discountProducts) > 0)
    <div class="mt-5">
        <h3 class="mb-4 fw-bold border-start border-4 border-danger ps-2 text-danger">Giá sốc hôm nay</h3>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($discountProducts as $product)
                <div class="col">
                    <x-client.product :product="$product" />
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Khu vực 3: Sản phẩm bán chạy -->
    <div class="mt-5 mb-5">
        <h3 class="mb-4 fw-bold border-start border-4 border-success ps-2">Sản phẩm bán chạy</h3>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($bestSellerProducts as $product)
                <div class="col">
                    <x-client.product :product="$product" />
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Xử lý nút Thêm vào giỏ hàng bằng AJAX
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        document.querySelectorAll('.btn-add-cart').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                
                fetch(`/cart/add/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Cập nhật số lượng giỏ hàng trên Header
                        document.getElementById('cart-count').innerText = data.cart_count;
                        
                        // Hiển thị thông báo (thay vì alert)
                        const alertHtml = `
                            <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 z-3 shadow-lg" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>${data.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `;
                        document.body.insertAdjacentHTML('beforeend', alertHtml);
                        
                        // Tự động tắt sau 3 giây
                        setTimeout(() => {
                            const alerts = document.querySelectorAll('.alert');
                            alerts.forEach(a => a.remove());
                        }, 3000);
                    }
                });
            });
        });
    });
</script>
@endpush

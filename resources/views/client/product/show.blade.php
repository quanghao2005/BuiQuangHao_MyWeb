@extends('client.layouts.app')
@section('title', $product->productname . ' - TechStore')

@section('content')
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.category', $product->category->slug ?? '') }}">{{ $product->category->catename ?? 'Danh mục' }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->productname }}</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm border-0 mb-5">
        <div class="row g-0">
            <div class="col-md-5 p-4 text-center">
                @if ($product->image)
                    <img src="{{ asset('storage/products/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->productname }}">
                @else
                    <img src="{{ asset('images/no-image.jpg') }}" class="img-fluid rounded" alt="No Image">
                @endif
            </div>
            <div class="col-md-7 p-4 bg-light">
                <div class="card-body h-100 d-flex flex-column justify-content-center">
                    <h2 class="card-title fw-bold mb-3">{{ $product->productname }}</h2>
                    
                    <p class="mb-2"><strong>Thương hiệu:</strong> <a href="{{ route('products.brand', $product->brand->slug ?? '') }}" class="text-decoration-none">{{ $product->brand->brandname ?? 'Đang cập nhật' }}</a></p>
                    <p class="mb-4"><strong>Tình trạng:</strong> <span class="badge bg-success">Còn hàng</span></p>

                    <div class="bg-white p-3 rounded shadow-sm mb-4">
                        @if($product->pricediscount > 0)
                            <h3 class="text-danger fw-bold mb-0">{{ number_format($product->pricediscount, 0, ',', '.') }}đ</h3>
                            <div class="text-muted text-decoration-line-through">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                            <span class="badge bg-danger mt-2">Tiết kiệm {{ number_format($product->price - $product->pricediscount, 0, ',', '.') }}đ</span>
                        @else
                            <h3 class="text-primary fw-bold mb-0">{{ number_format($product->price, 0, ',', '.') }}đ</h3>
                        @endif
                    </div>

                    <p class="card-text text-muted mb-4">{{ $product->description ?? 'Đang cập nhật mô tả sản phẩm...' }}</p>

                    <div class="mt-auto">
                        <button class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold btn-add-cart" data-id="{{ $product->id }}">
                            <i class="bi bi-cart-plus me-2"></i> THÊM VÀO GIỎ HÀNG
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($relatedProducts->count() > 0)
    <div class="mt-5 mb-5">
        <h4 class="fw-bold border-start border-4 border-info ps-2 mb-4">Sản phẩm liên quan</h4>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($relatedProducts as $relProduct)
                <div class="col">
                    <x-client.product :product="$relProduct" />
                </div>
            @endforeach
        </div>
    </div>
    @endif
@endsection

@push('scripts')
<script>
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
                        document.getElementById('cart-count').innerText = data.cart_count;
                        const alertHtml = `
                            <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 z-3 shadow-lg" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>${data.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        `;
                        document.body.insertAdjacentHTML('beforeend', alertHtml);
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

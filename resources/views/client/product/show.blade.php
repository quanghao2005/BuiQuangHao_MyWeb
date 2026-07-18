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
                <div class="main-image-container mb-3 border rounded shadow-sm overflow-hidden d-flex align-items-center justify-content-center" style="height: 400px; background-color: #fff;">
                    @if ($product->image)
                        <img id="mainImage" src="{{ asset('storage/products/' . $product->image) }}" class="img-fluid" style="max-height: 100%; object-fit: contain;" alt="{{ $product->productname }}">
                    @else
                        <img id="mainImage" src="{{ asset('images/no-image.jpg') }}" class="img-fluid" style="max-height: 100%; object-fit: contain;" alt="No Image">
                    @endif
                </div>

                @if($product->images && $product->images->count() > 0)
                <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
                    <!-- Các ảnh phụ -->
                    @foreach($product->images as $subImg)
                        <img src="{{ asset('storage/products/' . $subImg->image) }}" class="img-thumbnail sub-image-thumb" style="width: 80px; height: 80px; object-fit: contain; cursor: pointer;" onclick="changeMainImage(this, '{{ asset('storage/products/' . $subImg->image) }}')">
                    @endforeach
                </div>
                @endif
            </div>
            <div class="col-md-7 p-4 bg-body-tertiary">
                <div class="card-body h-100 d-flex flex-column justify-content-center">
                    <h2 class="card-title fw-bold mb-3">{{ $product->productname }}</h2>
                    
                    <p class="mb-2"><strong>Thương hiệu:</strong> <a href="{{ route('products.brand', $product->brand->slug ?? '') }}" class="text-decoration-none">{{ $product->brand->brandname ?? 'Đang cập nhật' }}</a></p>
                    <p class="mb-4"><strong>Tình trạng:</strong> <span class="badge bg-success">Còn hàng</span></p>

                    <div class="bg-body p-3 rounded shadow-sm mb-4">
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
                        // Hiển thị thông báo bằng SweetAlert2
                        if (typeof Toast !== 'undefined') {
                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            });
                        }
                    }
                });
            });
        });
    });

    const productImages = [
        "{{ asset('storage/products/' . ($product->image ? $product->image : 'no-image.jpg')) }}",
        @foreach($product->images as $img)
            "{{ asset('storage/products/' . $img->image) }}",
        @endforeach
    ];
    let currentImageIndex = 0;
    let autoSlideInterval;

    function changeMainImage(element, src) {
        document.getElementById('mainImage').src = src;
        // Xóa class active ở tất cả ảnh nhỏ
        document.querySelectorAll('.sub-image-thumb').forEach(thumb => {
            thumb.classList.remove('border-primary');
            thumb.classList.remove('border-2');
        });
        
        // Thêm class active cho ảnh được click nếu element hợp lệ
        if (element) {
            element.classList.add('border-primary');
            element.classList.add('border-2');
            // Cập nhật currentImageIndex dựa vào src
            currentImageIndex = productImages.indexOf(src);
        }
        
        // Reset timer khi người dùng tự click
        resetAutoSlide();
    }

    function nextImage() {
        if (productImages.length <= 1) return;
        currentImageIndex = (currentImageIndex + 1) % productImages.length;
        const nextSrc = productImages[currentImageIndex];
        
        // Cập nhật ảnh chính
        document.getElementById('mainImage').src = nextSrc;
        
        // Cập nhật viền cho ảnh nhỏ (nếu có)
        document.querySelectorAll('.sub-image-thumb').forEach(thumb => {
            thumb.classList.remove('border-primary');
            thumb.classList.remove('border-2');
            
            // So sánh src bằng cách lấy đường dẫn đầy đủ
            if (thumb.src === nextSrc || thumb.getAttribute('onclick').includes(nextSrc)) {
                thumb.classList.add('border-primary');
                thumb.classList.add('border-2');
            }
        });
    }

    function startAutoSlide() {
        if (productImages.length > 1) {
            autoSlideInterval = setInterval(nextImage, 3000);
        }
    }

    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        startAutoSlide();
    }

    // Khởi động auto slide khi tải trang
    document.addEventListener('DOMContentLoaded', function() {
        startAutoSlide();
    });
</script>
@endpush

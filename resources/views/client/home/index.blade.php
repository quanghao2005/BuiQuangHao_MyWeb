@extends('client.layouts.app')
@section('title', 'Trang chủ - TechStore')

@section('content')
    @push('styles')
    <style>
        .hero-banner {
            background: linear-gradient(-45deg, #0f172a, #1e1b4b, #312e81, #1e3a8a);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            border-radius: 2rem;
            overflow: hidden;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .blur-glow-1 {
            width: 25vw; height: 25vw; background: #8b5cf6;
            top: -5vw; left: -5vw; filter: blur(80px); opacity: 0.4;
        }
        .blur-glow-2 {
            width: 20vw; height: 20vw; background: #ec4899;
            bottom: -5vw; right: -5vw; filter: blur(80px); opacity: 0.3;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .text-gradient {
            background: linear-gradient(to right, #60a5fa, #c084fc, #f472b6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .floating-icon {
            animation: float 6s ease-in-out infinite;
            filter: drop-shadow(0 20px 30px rgba(0,0,0,0.4));
        }
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        .hover-scale { transition: transform 0.3s ease; }
        .hover-scale:hover { transform: scale(1.05); }

        /* Premium Carousel Animation */
        .carousel-fade .carousel-item {
            transition: opacity 1.2s ease-in-out, transform 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            transform: scale(1.02);
        }
        .carousel-fade .carousel-item.active {
            transform: scale(1);
        }
    </style>
    @endpush

    @if($banners->count() > 0)
    <!-- Banner Trình Chiếu Động -->
    <div id="heroCarousel" class="carousel slide carousel-fade mb-5 mt-3 shadow-lg" data-bs-ride="carousel" data-bs-interval="3000" style="border-radius: 1.5rem; overflow: hidden;">
        <div class="carousel-indicators">
            @foreach($banners as $index => $banner)
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($banners as $index => $banner)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}" style="min-height: 250px;">
                    <a href="{{ $banner->link ? $banner->link : '#' }}">
                        <img src="{{ asset('storage/' . $banner->image) }}" class="d-block w-100 rounded-4" alt="{{ $banner->title }}" style="object-fit: cover; max-height: 380px;">
                    </a>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: rgba(0,0,0,0.5); border-radius: 50%; padding: 1.5rem;"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: rgba(0,0,0,0.5); border-radius: 50%; padding: 1.5rem;"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    @else
    <!-- Banner Mặc Định (Carousel) -->
    <div id="defaultCarousel" class="carousel slide carousel-fade mb-5 mt-3 shadow-lg" data-bs-ride="carousel" data-bs-interval="4000" style="border-radius: 2rem; overflow: hidden;">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#defaultCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#defaultCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <div class="hero-banner position-relative" style="border-radius: 0;">
                    <div class="position-absolute rounded-circle blur-glow-1 z-0"></div>
                    <div class="position-absolute rounded-circle blur-glow-2 z-0"></div>
                    <div class="container-fluid py-4 position-relative z-1 d-flex align-items-center" style="min-height: 350px;">
                        <div class="row w-100 align-items-center mx-0">
                            <div class="col-lg-7 px-md-5 px-3">
                                <div class="glass-card p-4 rounded-4 text-start">
                                    <span class="badge bg-white text-dark px-3 py-2 rounded-pill mb-2 fw-bold shadow-sm" style="font-size: 0.8rem;">
                                        <i class="bi bi-stars text-warning me-1"></i> Trải nghiệm vượt giới hạn
                                    </span>
                                    <h1 class="display-6 fw-bolder text-white mb-3" style="line-height: 1.3;">
                                        Khai phá quyền năng <br>
                                        <span class="text-gradient">Công Nghệ Thông Minh</span>
                                    </h1>
                                    <p class="fs-6 text-light opacity-75 mb-4">
                                        Khám phá ngay bộ sưu tập thiết bị công nghệ đẳng cấp thế giới, thiết kế tinh xảo và hiệu năng đột phá, giúp định hình phong cách sống của bạn.
                                    </p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="#" class="btn btn-primary btn-md fw-bold px-4 py-2 rounded-pill shadow-lg hover-scale" style="background: linear-gradient(to right, #3b82f6, #8b5cf6); border: none;">
                                            Khám phá ngay <i class="bi bi-arrow-right-short fs-5 ms-1" style="vertical-align: middle;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 d-none d-lg-flex justify-content-center align-items-center">
                                <div class="position-relative floating-icon">
                                    <i class="bi bi-apple text-white opacity-25 position-absolute" style="font-size: 5rem; top: -30px; left: -10px; filter: blur(1px);"></i>
                                    <i class="bi bi-laptop text-white opacity-75" style="font-size: 10rem;"></i>
                                    <i class="bi bi-controller text-white opacity-50 position-absolute" style="font-size: 4rem; bottom: -10px; right: -20px; filter: blur(1px);"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <div class="hero-banner position-relative" style="border-radius: 0; background: linear-gradient(-45deg, #4c0519, #7f1d1d, #b91c1c, #9f1239);">
                    <div class="position-absolute rounded-circle blur-glow-1 z-0" style="background: #fbbf24;"></div>
                    <div class="position-absolute rounded-circle blur-glow-2 z-0" style="background: #f43f5e;"></div>
                    <div class="container-fluid py-4 position-relative z-1 d-flex align-items-center" style="min-height: 350px;">
                        <div class="row w-100 align-items-center mx-0">
                            <div class="col-lg-7 px-md-5 px-3">
                                <div class="glass-card p-4 rounded-4 text-start">
                                    <span class="badge bg-white text-danger px-3 py-2 rounded-pill mb-2 fw-bold shadow-sm" style="font-size: 0.8rem;">
                                        <i class="bi bi-fire text-danger me-1"></i> Ưu đãi chớp nhoáng
                                    </span>
                                    <h1 class="display-6 fw-bolder text-white mb-3" style="line-height: 1.3;">
                                        Giảm giá cực sốc <br>
                                        <span class="text-warning">Lên Tới 50%</span>
                                    </h1>
                                    <p class="fs-6 text-light opacity-75 mb-4">
                                        Nhanh tay sở hữu những siêu phẩm công nghệ hot nhất với mức giá không tưởng. Số lượng có hạn, chớp lấy ngay cơ hội vàng này!
                                    </p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="#" class="btn btn-warning text-dark btn-md fw-bold px-4 py-2 rounded-pill shadow-lg hover-scale" style="border: none;">
                                            Săn sale ngay <i class="bi bi-cart-check fs-5 ms-1" style="vertical-align: middle;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 d-none d-lg-flex justify-content-center align-items-center">
                                <div class="position-relative floating-icon">
                                    <i class="bi bi-percent text-white opacity-25 position-absolute" style="font-size: 5rem; top: -30px; left: -10px; filter: blur(1px);"></i>
                                    <i class="bi bi-gift text-white opacity-75" style="font-size: 10rem;"></i>
                                    <i class="bi bi-tag text-white opacity-50 position-absolute" style="font-size: 4rem; bottom: -10px; right: -20px; filter: blur(1px);"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Điều khiển qua lại -->
        <button class="carousel-control-prev" type="button" data-bs-target="#defaultCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: rgba(0,0,0,0.5); border-radius: 50%; padding: 1.5rem;"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#defaultCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: rgba(0,0,0,0.5); border-radius: 50%; padding: 1.5rem;"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    @endif

    <!-- Khu vực 1: Sản phẩm mới nhất -->
    <div class="mt-5">
        <h3 class="mb-4 section-title text-dark"><i class="bi bi-stars text-primary me-2"></i>Sản phẩm mới nhất</h3>
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
        <h3 class="mb-4 section-title text-danger"><i class="bi bi-lightning-charge-fill text-danger me-2"></i>Giá sốc hôm nay</h3>
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
        <h3 class="mb-4 section-title text-success"><i class="bi bi-fire text-success me-2"></i>Sản phẩm bán chạy</h3>
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
</script>
@endpush

<header class="bg-white py-3 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="text-decoration-none">
            <h2 class="text-primary fw-bold mb-0"><i class="bi bi-shop me-2"></i>TechStore</h2>
        </a>

        <!-- Search Bar -->
        <form action="{{ route('products.search') }}" method="GET" class="d-flex w-50 mx-4">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="{{ request('q') }}" required>
                <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>

        <!-- Cart Icon -->
        <div>
            @php $cart = session('cart', []); @endphp
            <a href="{{ route('cart.index') }}" class="btn btn-primary position-relative">
                <i class="bi bi-cart3"></i> Giỏ hàng
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">
                    {{ count($cart) }}
                </span>
            </a>
            
            @if(Auth::check())
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark ms-2"><i class="bi bi-person"></i> Admin</a>
            @else
                <a href="{{ route('admin.login') }}" class="btn btn-outline-dark ms-2"><i class="bi bi-box-arrow-in-right"></i> Đăng nhập</a>
            @endif
        </div>
    </div>
</header>

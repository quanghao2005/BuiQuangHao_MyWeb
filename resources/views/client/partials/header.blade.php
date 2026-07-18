<nav class="navbar navbar-expand-lg bg-body sticky-top shadow-sm p-0">
    <div class="w-100">
        <!-- Top Row: Logo & Toggler -->
        <div class="container d-flex align-items-center justify-content-between py-3 position-relative">
            <!-- Logo -->
            <a class="navbar-brand text-decoration-none mb-0" href="{{ route('home') }}">
                <h3 class="text-body fw-bold mb-0"><i class="bi bi-shop me-2 text-primary"></i>TechStore</h3>
            </a>

            <!-- Mobile Toggler -->
            <button class="navbar-toggler border-0 position-absolute end-0 me-3 d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <!-- Bottom Row: Menu, Search, Cart -->
        <div class="border-top">
            <div class="container">
                <div class="collapse navbar-collapse py-2" id="mainNavbar">
            
            <!-- Navbar Links -->
            @include('client.partials.navbar')

            <!-- Search Bar -->
            <form action="{{ route('products.search') }}" method="GET" class="d-flex position-relative mx-auto my-3 my-lg-0" style="max-width: 400px; width: 100%;">
                <div class="input-group">
                    <input type="text" name="q" id="search-input" class="form-control rounded-start-pill ps-4" placeholder="Tìm kiếm sản phẩm..." value="{{ request('q') }}" autocomplete="off" required>
                    <button class="btn btn-primary rounded-end-pill px-4" type="submit"><i class="bi bi-search"></i></button>
                </div>
                
                <!-- Kết quả tìm kiếm realtime -->
                <div id="search-results-dropdown" class="position-absolute w-100 bg-body border rounded-3 shadow-lg d-none z-3" style="top: 100%; left: 0; max-height: 400px; overflow-y: auto; margin-top: 10px;">
                    <div class="list-group list-group-flush" id="search-results-list">
                        <!-- JS sẽ inject kết quả vào đây -->
                    </div>
                </div>
            </form>

            <!-- User & Cart -->
            <div class="d-flex align-items-center justify-content-center gap-3 ms-lg-3">
                <!-- Theme Toggle -->
                <button id="theme-toggle" class="btn bg-body-secondary rounded-circle d-flex align-items-center justify-content-center border-0" style="width: 45px; height: 45px; transition: background-color 0.3s;" title="Chuyển đổi giao diện">
                    <i class="bi bi-moon-stars fs-5 text-body"></i>
                </button>

                @php $cart = session('cart', []); @endphp
            <a href="{{ route('cart.index') }}" class="position-relative text-body text-decoration-none d-flex align-items-center hover-primary" title="Giỏ hàng">
                <div class="bg-body-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; transition: background-color 0.3s;">
                    <i class="bi bi-cart3 fs-5 text-body"></i>
                </div>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm" id="cart-count" style="font-size: 0.75rem; border: 2px solid var(--bs-body-bg);">
                    {{ count($cart) }}
                </span>
            </a>
            
            @if(Auth::check())
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-body text-decoration-none dropdown-toggle hover-primary" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('uploads/avatars/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->fullname }}" class="rounded-circle me-2 shadow-sm" style="width: 45px; height: 45px; object-fit: cover; border: 2px solid var(--bs-border-color);">
                        @else
                            <div class="bg-body-secondary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 45px; height: 45px;">
                                <i class="bi bi-person fs-5 text-body"></i>
                            </div>
                        @endif
                        <div class="d-none d-md-block lh-sm">
                            <small class="text-muted d-block" style="font-size: 0.75rem;">Tài khoản</small>
                            <span class="fw-semibold text-body" style="font-size: 0.9rem;">{{ Auth::user()->fullname }}</span>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><a class="dropdown-item py-2" href="{{ route('profile.index') }}"><i class="bi bi-person-badge me-2 text-primary"></i>Thông tin tài khoản</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('profile.orders') }}"><i class="bi bi-bag-check me-2 text-primary"></i>Lịch sử mua hàng</a></li>
                        @if(Auth::user()->role == 1)
                            <li><a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2 text-primary"></i>Quản trị Admin</a></li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="mb-0">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="d-flex align-items-center text-body text-decoration-none hover-primary">
                    <div class="bg-body-secondary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 45px; height: 45px;">
                        <i class="bi bi-person fs-5 text-body"></i>
                    </div>
                    <div class="d-none d-md-block lh-sm">
                        <small class="text-muted d-block" style="font-size: 0.75rem;">Đăng nhập /</small>
                        <span class="fw-semibold text-body" style="font-size: 0.9rem;">Đăng ký</span>
                    </div>
                </a>
            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const dropdown = document.getElementById('search-results-dropdown');
        const resultsList = document.getElementById('search-results-list');
        let timeout = null;

        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            const query = this.value.trim();

            if (query.length < 1) {
                dropdown.classList.add('d-none');
                return;
            }

            // Đợi người dùng ngưng gõ 300ms rồi mới tìm
            timeout = setTimeout(() => {
                fetch(`/ajax-search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        resultsList.innerHTML = '';
                        if (data.length === 0) {
                            resultsList.innerHTML = '<div class="p-3 text-center text-muted">Không tìm thấy sản phẩm nào</div>';
                        } else {
                            data.forEach(item => {
                                let priceHtml = '';
                                if (item.discount_format) {
                                    priceHtml = `<span class="text-danger fw-bold me-2">${item.discount_format}</span>
                                                 <small class="text-muted text-decoration-line-through">${item.price_format}</small>`;
                                } else {
                                    priceHtml = `<span class="text-primary fw-bold">${item.price_format}</span>`;
                                }

                                const html = `
                                    <a href="${item.url}" class="list-group-item list-group-item-action d-flex align-items-center py-2">
                                        <img src="${item.image_url}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: contain;">
                                        <div>
                                            <h6 class="mb-1 text-truncate" style="max-width: 250px;">${item.productname}</h6>
                                            <div class="mb-0">${priceHtml}</div>
                                        </div>
                                    </a>
                                `;
                                resultsList.insertAdjacentHTML('beforeend', html);
                            });
                        }
                        dropdown.classList.remove('d-none');
                    })
                    .catch(error => {
                        console.error('Lỗi tìm kiếm:', error);
                    });
            }, 300);
        });

        // Đóng dropdown khi click ra ngoài
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('d-none');
            }
        });
        
        // Mở lại nếu click vào ô input
        searchInput.addEventListener('focus', function() {
            if (this.value.trim().length > 0 && resultsList.innerHTML !== '') {
                dropdown.classList.remove('d-none');
            }
        });

        // Theme Toggle Logic
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeIcon = themeToggleBtn.querySelector('i');
        
        if (document.documentElement.getAttribute('data-bs-theme') === 'dark') {
            themeIcon.classList.replace('bi-moon-stars', 'bi-sun');
        }

        themeToggleBtn.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            if (newTheme === 'dark') {
                themeIcon.classList.replace('bi-moon-stars', 'bi-sun');
            } else {
                themeIcon.classList.replace('bi-sun', 'bi-moon-stars');
            }
        });
    });
</script>
@endpush

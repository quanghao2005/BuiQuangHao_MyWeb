            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-lg-3">
                <li class="nav-item">
                    <a class="nav-link text-nowrap {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap {{ Route::is('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">Sản phẩm</a>
                </li>
                
                <!-- Dropdown Danh mục (Mega Menu) -->
                <li class="nav-item dropdown mega-dropdown">
                    <a class="nav-link text-nowrap dropdown-toggle" href="#" id="navbarCategory" role="button" data-bs-toggle="dropdown">
                        Danh mục
                    </a>
                    <div class="dropdown-menu mega-menu">
                        <div class="mega-menu-container">
                            <!-- Cột Trái: Cuộn Danh mục -->
                            <div class="mega-menu-left mega-menu-left-scroll">
                                @foreach($sharedCategories as $cat)
                                    <a class="mega-menu-left-item d-flex align-items-center" data-target="mega-panel-{{ $cat->cateid }}" href="{{ route('products.category', $cat->slug) }}">
                                        @if($cat->image && str_starts_with($cat->image, 'http'))
                                            <img src="{{ $cat->image }}" alt="{{ $cat->catename }}" class="me-2 rounded" style="width: 24px; height: 24px; object-fit: cover;">
                                        @elseif($cat->image && file_exists(public_path('storage/categories/' . $cat->image)))
                                            <img src="{{ asset('storage/categories/' . $cat->image) }}" alt="{{ $cat->catename }}" class="me-2 rounded" style="width: 24px; height: 24px; object-fit: cover;">
                                        @else
                                            <i class="bi bi-box-seam me-2 text-muted"></i>
                                        @endif
                                        <span class="flex-grow-1">{{ $cat->catename }}</span>
                                        <i class="bi bi-chevron-right ms-2 text-muted"></i>
                                    </a>
                                @endforeach
                            </div>
                            
                            <!-- Cột Phải: Nội dung Mega -->
                            <div class="mega-menu-right">
                                <!-- Màn hình chờ mặc định -->
                                <div id="mega-panel-default" class="mega-content-panel active">
                                    <div class="text-center mt-5 text-muted">
                                        <i class="bi bi-cursor fs-1"></i>
                                        <p class="mt-2">Rê chuột vào một danh mục để xem chi tiết</p>
                                    </div>
                                </div>

                                <!-- Màn hình chi tiết cho từng Danh mục -->
                                @foreach($sharedCategories as $cat)
                                    <div id="mega-panel-{{ $cat->cateid }}" class="mega-content-panel">
                                        <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                            <h5 class="fw-bold mb-0 text-primary">{{ $cat->catename }} Nổi Bật</h5>
                                            <a href="{{ route('products.category', $cat->slug) }}" class="text-decoration-none small text-muted hover-primary">Xem tất cả <i class="bi bi-arrow-right"></i></a>
                                        </div>
                                        
                                        @php
                                            $catProducts = \App\Models\Product::where('cateid', $cat->cateid)->where('status', 1)->take(4)->get();
                                        @endphp

                                        <div class="row g-3">
                                            @if($catProducts->count() > 0)
                                                @foreach($catProducts as $p)
                                                    <div class="col-md-3">
                                                        <a href="{{ route('products.show', $p->slug) }}" class="text-decoration-none">
                                                            <div class="card h-100 border-0 shadow-sm mega-product-card">
                                                                <div class="p-2 text-center">
                                                                    <img src="{{ asset('storage/products/' . ($p->image ? $p->image : 'no-image.jpg')) }}" class="img-fluid rounded" style="height: 100px; object-fit: contain;" alt="{{ $p->productname }}">
                                                                </div>
                                                                <div class="card-body p-2 text-center">
                                                                    <h6 class="card-title text-dark mb-1 text-truncate" style="font-size: 0.85rem;" title="{{ $p->productname }}">{{ $p->productname }}</h6>
                                                                    <div class="text-primary fw-bold" style="font-size: 0.9rem;">
                                                                        @if($p->pricediscount > 0)
                                                                            <span class="text-danger">{{ number_format($p->pricediscount, 0, ',', '.') }}đ</span>
                                                                        @else
                                                                            <span>{{ number_format($p->price, 0, ',', '.') }}đ</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="col-12 text-center py-4 text-muted">
                                                    Đang cập nhật sản phẩm...
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </li>

                <!-- Dropdown Thương hiệu (Mega Menu) -->
                <li class="nav-item dropdown mega-dropdown">
                    <a class="nav-link text-nowrap dropdown-toggle" href="#" id="navbarBrand" role="button" data-bs-toggle="dropdown">
                        Thương hiệu
                    </a>
                    <div class="dropdown-menu mega-menu">
                        <div class="mega-menu-container">
                            <!-- Cột Trái: Cuộn Thương hiệu -->
                            <div class="mega-menu-left mega-menu-left-scroll">
                                @foreach($sharedBrands as $brand)
                                    <a class="mega-menu-left-item d-flex align-items-center" data-target="mega-brand-panel-{{ $brand->brandid }}" href="{{ route('products.brand', $brand->slug) }}">
                                        @if($brand->image && str_starts_with($brand->image, 'http'))
                                            <img src="{{ $brand->image }}" alt="{{ $brand->brandname }}" class="me-2" style="width: 24px; height: 24px; object-fit: contain;">
                                        @elseif($brand->image && file_exists(public_path('storage/brands/' . $brand->image)))
                                            <img src="{{ asset('storage/brands/' . $brand->image) }}" alt="{{ $brand->brandname }}" class="me-2" style="width: 24px; height: 24px; object-fit: contain;">
                                        @else
                                            <i class="bi bi-tag me-2 text-muted"></i>
                                        @endif
                                        <span class="flex-grow-1">{{ $brand->brandname }}</span>
                                        <i class="bi bi-chevron-right ms-2 text-muted"></i>
                                    </a>
                                @endforeach
                            </div>
                            
                            <!-- Cột Phải: Nội dung Mega -->
                            <div class="mega-menu-right">
                                <!-- Màn hình chờ mặc định -->
                                <div id="mega-brand-panel-default" class="mega-content-panel active">
                                    <div class="text-center mt-5 text-muted">
                                        <i class="bi bi-cursor fs-1"></i>
                                        <p class="mt-2">Rê chuột vào một thương hiệu để xem chi tiết</p>
                                    </div>
                                </div>

                                <!-- Màn hình chi tiết cho từng Thương hiệu -->
                                @foreach($sharedBrands as $brand)
                                    <div id="mega-brand-panel-{{ $brand->brandid }}" class="mega-content-panel">
                                        <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                            <h5 class="fw-bold mb-0 text-primary">{{ $brand->brandname }} Nổi Bật</h5>
                                            <a href="{{ route('products.brand', $brand->slug) }}" class="text-decoration-none small text-muted hover-primary">Xem tất cả <i class="bi bi-arrow-right"></i></a>
                                        </div>
                                        
                                        @php
                                            $brandProducts = \App\Models\Product::where('brandid', $brand->brandid)->where('status', 1)->take(4)->get();
                                        @endphp

                                        <div class="row g-3">
                                            @if($brandProducts->count() > 0)
                                                @foreach($brandProducts as $p)
                                                    <div class="col-md-3">
                                                        <a href="{{ route('products.show', $p->slug) }}" class="text-decoration-none">
                                                            <div class="card h-100 border-0 shadow-sm mega-product-card">
                                                                <div class="p-2 text-center">
                                                                    <img src="{{ asset('storage/products/' . ($p->image ? $p->image : 'no-image.jpg')) }}" class="img-fluid rounded" style="height: 100px; object-fit: contain;" alt="{{ $p->productname }}">
                                                                </div>
                                                                <div class="card-body p-2 text-center">
                                                                    <h6 class="card-title text-dark mb-1 text-truncate" style="font-size: 0.85rem;" title="{{ $p->productname }}">{{ $p->productname }}</h6>
                                                                    <div class="text-primary fw-bold" style="font-size: 0.9rem;">
                                                                        @if($p->pricediscount > 0)
                                                                            <span class="text-danger">{{ number_format($p->pricediscount, 0, ',', '.') }}đ</span>
                                                                        @else
                                                                            <span>{{ number_format($p->price, 0, ',', '.') }}đ</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="col-12 text-center py-4 text-muted">
                                                    Đang cập nhật sản phẩm...
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </li>
                
                <!-- Bài viết -->
                <li class="nav-item">
                    <a class="nav-link text-nowrap {{ Route::is('client.posts.*') ? 'active' : '' }}" href="{{ route('client.posts.index') }}">Bài viết</a>
                </li>
            </ul>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const containers = document.querySelectorAll('.mega-menu-container');
    
    containers.forEach(container => {
        const items = container.querySelectorAll('.mega-menu-left-item');
        const panels = container.querySelectorAll('.mega-content-panel');

        items.forEach(item => {
            item.addEventListener('mouseenter', function() {
                // Remove active classes trong container hiện tại
                items.forEach(i => i.classList.remove('active'));
                panels.forEach(p => p.classList.remove('active'));

                // Add active class to hovered item and corresponding panel
                this.classList.add('active');
                const targetId = this.getAttribute('data-target');
                const targetPanel = document.getElementById(targetId);
                if(targetPanel) {
                    targetPanel.classList.add('active');
                }
            });
        });
    });
});
</script>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#clientNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="clientNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}">Trang chủ</a>
                </li>
                
                <!-- Dropdown Danh mục -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarCategory" role="button" data-bs-toggle="dropdown">
                        Danh mục
                    </a>
                    <ul class="dropdown-menu">
                        @foreach($sharedCategories as $cat)
                            <li><a class="dropdown-item" href="{{ route('products.category', $cat->slug) }}">{{ $cat->catename }}</a></li>
                        @endforeach
                    </ul>
                </li>

                <!-- Dropdown Thương hiệu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarBrand" role="button" data-bs-toggle="dropdown">
                        Thương hiệu
                    </a>
                    <ul class="dropdown-menu">
                        @foreach($sharedBrands as $brand)
                            <li><a class="dropdown-item" href="{{ route('products.brand', $brand->slug) }}">{{ $brand->brandname }}</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

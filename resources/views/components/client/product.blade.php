@props(['product'])

<div class="card h-100 product-card shadow-sm border-0 position-relative">
    <!-- Sale Badge -->
    @if($product->pricediscount > 0)
        <div class="position-absolute top-0 start-0 m-2">
            <span class="badge bg-danger rounded-pill px-2 py-1">
                -{{ round((($product->price - $product->pricediscount) / $product->price) * 100) }}%
            </span>
        </div>
    @endif

    <a href="{{ route('products.show', $product->slug) }}" class="product-image-container d-block">
        @if ($product->image)
            <img src="{{ asset('storage/products/' . $product->image) }}" class="card-img-top product-image rounded-4" alt="{{ $product->productname }}">
        @else
            <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top product-image rounded-4" alt="No Image">
        @endif
    </a>

    <div class="card-body d-flex flex-column">
        <h6 class="card-title text-truncate">
            <a href="{{ route('products.show', $product->slug) }}" class="text-dark text-decoration-none fw-bold">
                {{ $product->productname }}
            </a>
        </h6>
        
        <div class="mt-auto">
            @if($product->pricediscount > 0)
                <span class="text-danger fw-bold fs-5">{{ number_format($product->pricediscount, 0, ',', '.') }}đ</span>
                <span class="text-muted text-decoration-line-through small ms-2">{{ number_format($product->price, 0, ',', '.') }}đ</span>
            @else
                <span class="text-primary fw-bold fs-5">{{ number_format($product->price, 0, ',', '.') }}đ</span>
            @endif
        </div>

        <button class="btn btn-gradient rounded-pill mt-3 w-100 btn-add-cart fw-bold shadow-sm" data-id="{{ $product->id }}">
            <i class="bi bi-cart-plus me-1"></i> Thêm vào giỏ
        </button>
    </div>
</div>

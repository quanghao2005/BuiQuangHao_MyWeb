@extends('client.layouts.app')
@section('title', $title . ' - TechStore')

@section('content')
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
            <h3 class="fw-bold border-start border-4 border-primary ps-2 mb-0">{{ $title }}</h3>
        </div>
        
        <div class="dropdown">
            <button class="btn btn-white border shadow-sm dropdown-toggle fw-semibold text-muted" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                <i class="bi bi-sliders me-1"></i> Lọc theo giá
            </button>
            <div class="dropdown-menu dropdown-menu-end p-3 shadow-lg border-0" style="width: 320px;">
                <form action="{{ url()->current() }}" method="GET">
                    @if(request()->has('q'))
                        <input type="hidden" name="q" value="{{ request('q') }}">
                    @endif
                    <h6 class="fw-bold mb-3">Khoảng giá (VNĐ)</h6>
                    
                    <div class="d-flex align-items-center mb-3 gap-2">
                        <input type="number" name="min_price" id="inputMin" class="form-control form-control-sm text-center" placeholder="Từ" value="{{ request('min_price') }}" min="0" oninput="document.getElementById('rangeMin').value=this.value">
                        <span class="text-muted">-</span>
                        <input type="number" name="max_price" id="inputMax" class="form-control form-control-sm text-center" placeholder="Đến" value="{{ request('max_price') }}" min="0" oninput="document.getElementById('rangeMax').value=this.value">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted mb-0">Tối thiểu</label>
                        <input type="range" class="form-range" id="rangeMin" min="0" max="50000000" step="100000" value="{{ request('min_price', 0) }}" oninput="document.getElementById('inputMin').value=this.value">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted mb-0">Tối đa</label>
                        <input type="range" class="form-range" id="rangeMax" min="0" max="100000000" step="500000" value="{{ request('max_price', 100000000) }}" oninput="document.getElementById('inputMax').value=this.value">
                    </div>
                    
                    <hr class="my-2">
                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ url()->current() }}{{ request()->has('q') ? '?q='.request('q') : '' }}" class="btn btn-sm btn-light border w-50">Xóa lọc</a>
                        <button type="submit" class="btn btn-primary btn-sm w-50">Áp dụng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($products->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5" id="product-list">
            @include('client.product.partials.product_list', ['products' => $products])
        </div>
        
        <!-- Nút Xem thêm -->
        @if($products->hasMorePages())
            <div class="d-flex justify-content-center mt-4 mb-5" id="load-more-container">
                <button class="btn btn-outline-primary px-5 py-2 fw-bold rounded-pill" id="btn-load-more" data-next-page="{{ $products->nextPageUrl() }}">
                    Xem thêm sản phẩm <i class="bi bi-chevron-down ms-1"></i>
                </button>
            </div>
        @endif
    @else
        <div class="text-center py-5">
            <img src="{{ asset('images/no-data.png') }}" alt="No data" style="width: 150px; opacity: 0.5">
            <h5 class="text-muted mt-3">Không tìm thấy sản phẩm nào phù hợp.</h5>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">Quay lại trang chủ</a>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    // AJAX Add to cart
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Use event delegation for dynamically loaded elements
        document.body.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-add-cart');
            if(btn) {
                const productId = btn.getAttribute('data-id');
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
            }
        });

        // Load More functionality
        const btnLoadMore = document.getElementById('btn-load-more');
        if (btnLoadMore) {
            btnLoadMore.addEventListener('click', function() {
                const url = this.getAttribute('data-next-page');
                if (!url) return;
                
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Đang tải...';
                this.disabled = true;

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.html) {
                        document.getElementById('product-list').insertAdjacentHTML('beforeend', data.html);
                        
                        if(data.next_page_url) {
                            this.setAttribute('data-next-page', data.next_page_url);
                            this.innerHTML = originalText;
                            this.disabled = false;
                        } else {
                            // No more pages
                            document.getElementById('load-more-container').remove();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading more products:', error);
                    this.innerHTML = originalText;
                    this.disabled = false;
                });
            });
        }
    });
</script>
@endpush

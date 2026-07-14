@extends('client.layouts.app')
@section('title', $title . ' - TechStore')

@section('content')
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
        <h3 class="fw-bold border-start border-4 border-primary ps-2">{{ $title }}</h3>
    </div>

    @if($products->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
            @foreach($products as $product)
                <div class="col">
                    <x-client.product :product="$product" />
                </div>
            @endforeach
        </div>
        
        <!-- Phân trang -->
        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
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
    // AJAX Add to cart (tương tự trang chủ)
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

@extends('client.layouts.app')
@section('title', 'Giỏ hàng của bạn - TechStore')

@section('content')
    <div class="mb-4">
        <h3 class="fw-bold border-start border-4 border-primary ps-2">Giỏ hàng của bạn</h3>
    </div>

    @if(count($cart) > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="ps-4" style="width: 40px;">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </th>
                                        <th scope="col">Sản phẩm</th>
                                        <th scope="col" class="text-center">Đơn giá</th>
                                        <th scope="col" class="text-center" style="width: 150px;">Số lượng</th>
                                        <th scope="col" class="text-center">Thành tiền</th>
                                        <th scope="col" class="text-end pe-4">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form id="checkout-form" action="{{ route('checkout') }}" method="POST">
                                        @csrf
                                        @foreach($cart as $id => $item)
                                            <tr>
                                                <td class="ps-4 py-3 align-middle">
                                                    <input class="form-check-input item-checkbox" type="checkbox" name="selected_items[]" value="{{ $id }}" data-price="{{ $item['price'] }}">
                                                </td>
                                                <td class="py-3">
                                                    <div class="d-flex align-items-center">
                                                        @if ($item['image'])
                                                            <img src="{{ asset('storage/products/' . $item['image']) }}" alt="{{ $item['proname'] }}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                        @else
                                                            <img src="{{ asset('images/no-image.jpg') }}" alt="No Image" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                        @endif
                                                        <div>
                                                            <a href="{{ route('products.show', \App\Models\Product::find($id)->slug ?? '') }}" class="text-dark fw-bold text-decoration-none d-block text-truncate" style="max-width: 200px;">{{ $item['proname'] }}</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center text-danger fw-bold align-middle">
                                                    {{ number_format($item['price'], 0, ',', '.') }}đ
                                                </td>
                                                <td class="text-center align-middle">
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <input type="number" class="form-control form-control-sm text-center w-50 item-quantity" data-id="{{ $id }}" value="{{ $item['quantity'] }}" min="1">
                                                    </div>
                                                </td>
                                                <td class="text-center text-primary fw-bold align-middle item-total" id="item-total-{{ $id }}">
                                                    {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ
                                                </td>
                                                <td class="text-end pe-4 align-middle">
                                                    <a href="{{ route('cart.remove', $id) }}" class="btn btn-sm btn-outline-danger btn-delete-cart-item">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </form>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <a href="{{ route('home') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-2"></i>Tiếp tục mua sắm</a>
            </div>

            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card shadow-sm border-0 bg-primary text-white">
                    <div class="card-body p-4">
                        <h4 class="card-title fw-bold border-bottom pb-3 mb-4 border-light">Tổng giỏ hàng</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Đã chọn:</span>
                            <span class="fw-bold" id="selected-count">0 sản phẩm</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tạm tính:</span>
                            <span class="fw-bold" id="cart-subtotal">0đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Phí vận chuyển:</span>
                            <span class="fw-bold">Miễn phí</span>
                        </div>
                        <hr class="border-light">
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fs-5">Tổng cộng:</span>
                            <span class="fs-4 fw-bold" id="cart-total">0đ</span>
                        </div>
                        
                        <button type="button" onclick="document.getElementById('checkout-form').submit()" class="btn btn-light btn-lg w-100 fw-bold rounded-pill text-primary" id="btn-checkout" disabled>TIẾN HÀNH THANH TOÁN</button>
                    </div>
                </div>
            </div>
        </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCb = document.getElementById('selectAll');
        const itemCbs = document.querySelectorAll('.item-checkbox');
        const quantityInputs = document.querySelectorAll('.item-quantity');
        const cartSubtotal = document.getElementById('cart-subtotal');
        const cartTotal = document.getElementById('cart-total');
        const selectedCount = document.getElementById('selected-count');
        const btnCheckout = document.getElementById('btn-checkout');

        // Hàm format tiền
        function formatMoney(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount) + 'đ';
        }

        // Hàm tính tổng tiền các sản phẩm được chọn
        function calculateTotal() {
            let total = 0;
            let count = 0;
            itemCbs.forEach(cb => {
                if (cb.checked) {
                    const price = parseFloat(cb.dataset.price);
                    const qtyInput = cb.closest('tr').querySelector('.item-quantity');
                    const qty = parseInt(qtyInput.value);
                    total += price * qty;
                    count++;
                }
            });

            cartSubtotal.textContent = formatMoney(total);
            cartTotal.textContent = formatMoney(total);
            selectedCount.textContent = count + ' sản phẩm';

            // Kích hoạt/Vô hiệu hóa nút thanh toán
            btnCheckout.disabled = count === 0;
        }

        // Sự kiện "Chọn tất cả"
        selectAllCb.addEventListener('change', function() {
            itemCbs.forEach(cb => cb.checked = this.checked);
            calculateTotal();
        });

        // Sự kiện "Chọn từng item"
        itemCbs.forEach(cb => {
            cb.addEventListener('change', function() {
                const allChecked = Array.from(itemCbs).every(c => c.checked);
                selectAllCb.checked = allChecked;
                calculateTotal();
            });
        });

        // Sự kiện thay đổi số lượng bằng AJAX
        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                const id = this.dataset.id;
                const quantity = this.value;

                if (quantity < 1) {
                    this.value = 1;
                    return;
                }

                // Call AJAX to update server cart
                fetch('{{ route("cart.update_ajax") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ id: id, quantity: quantity })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Cập nhật thành tiền của item
                        const itemTotalEl = document.getElementById('item-total-' + id);
                        itemTotalEl.textContent = formatMoney(data.item_total);
                        
                        // Cập nhật số lượng trên header
                        const cartCountEl = document.getElementById('cart-count');
                        if (cartCountEl) cartCountEl.textContent = data.cart_count;

                        // Cập nhật tổng tiền
                        calculateTotal();
                    }
                })
                .catch(err => console.error('Lỗi khi cập nhật giỏ hàng:', err));
            });
        });

        // Xác nhận xóa bằng SweetAlert2
        const deleteBtns = document.querySelectorAll('.btn-delete-cart-item');
        deleteBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.href;
                
                Swal.fire({
                    title: 'Xóa sản phẩm?',
                    text: "Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-trash"></i> Đồng ý xóa',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    });
</script>
@endpush
    @else
        <div class="text-center py-5">
            <i class="bi bi-cart-x text-muted opacity-25" style="font-size: 8rem;"></i>
            <h4 class="text-muted mt-4">Giỏ hàng của bạn đang trống</h4>
            <p class="text-muted">Chưa có sản phẩm nào trong giỏ hàng.</p>
            <a href="{{ route('home') }}" class="btn btn-primary btn-lg mt-3 px-5 rounded-pill"><i class="bi bi-cart me-2"></i>Mua sắm ngay</a>
        </div>
    @endif
@endsection

@extends('admin.layouts.admin')
@section('title', 'Tổng quan hệ thống')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Bảng điều khiển (Dashboard)</h2>
    <div>
        <a href="{{ route('home') }}" class="btn btn-primary rounded-pill shadow-sm px-4">
            <i class="bi bi-shop me-2"></i>Xem trang web
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Doanh thu -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white overflow-hidden">
            <div class="card-body p-4 position-relative">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="text-muted mb-1 text-uppercase fw-semibold" style="font-size: 0.8rem;">Tổng doanh thu</p>
                        <h3 class="fw-bold mb-0 text-success" id="stat-revenue">{{ number_format($totalRevenue, 0, ',', '.') }}đ</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-currency-dollar text-success fs-4"></i>
                    </div>
                </div>
                <div class="mt-2 text-sm">
                    <span class="text-success"><i class="bi bi-arrow-up-short"></i> Tăng trưởng tốt</span>
                </div>
                <div class="position-absolute bottom-0 end-0 opacity-10" style="transform: translate(20%, 20%);">
                    <i class="bi bi-graph-up-arrow" style="font-size: 6rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Đơn hàng -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white overflow-hidden">
            <div class="card-body p-4 position-relative">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="text-muted mb-1 text-uppercase fw-semibold" style="font-size: 0.8rem;">Đơn hàng</p>
                        <h3 class="fw-bold mb-0 text-primary" id="stat-orders">{{ $totalOrders }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-cart-check text-primary fs-4"></i>
                    </div>
                </div>
                <div class="mt-2 text-sm">
                    <span class="text-muted">Tổng số hóa đơn</span>
                </div>
                <div class="position-absolute bottom-0 end-0 opacity-10" style="transform: translate(20%, 20%);">
                    <i class="bi bi-box-seam" style="font-size: 6rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Sản phẩm -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white overflow-hidden">
            <div class="card-body p-4 position-relative">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="text-muted mb-1 text-uppercase fw-semibold" style="font-size: 0.8rem;">Sản phẩm</p>
                        <h3 class="fw-bold mb-0 text-warning" id="stat-products">{{ $totalProducts }}</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-tags text-warning fs-4"></i>
                    </div>
                </div>
                <div class="mt-2 text-sm">
                    <span class="text-muted">Mặt hàng trong kho</span>
                </div>
                <div class="position-absolute bottom-0 end-0 opacity-10" style="transform: translate(20%, 20%);">
                    <i class="bi bi-laptop" style="font-size: 6rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Người dùng -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white overflow-hidden">
            <div class="card-body p-4 position-relative">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="text-muted mb-1 text-uppercase fw-semibold" style="font-size: 0.8rem;">Khách hàng</p>
                        <h3 class="fw-bold mb-0 text-info" id="stat-users">{{ $totalUsers }}</h3>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-people text-info fs-4"></i>
                    </div>
                </div>
                <div class="mt-2 text-sm">
                    <span class="text-muted">Tài khoản thành viên</span>
                </div>
                <div class="position-absolute bottom-0 end-0 opacity-10" style="transform: translate(20%, 20%);">
                    <i class="bi bi-person-badge" style="font-size: 6rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Biểu đồ doanh thu</h5>
                <div class="btn-group" role="group" aria-label="Chart Period">
                    <input type="radio" class="btn-check" name="chartPeriod" id="period-day" value="day">
                    <label class="btn btn-outline-primary btn-sm" for="period-day">Ngày</label>

                    <input type="radio" class="btn-check" name="chartPeriod" id="period-week" value="week" checked>
                    <label class="btn btn-outline-primary btn-sm" for="period-week">Tuần</label>

                    <input type="radio" class="btn-check" name="chartPeriod" id="period-month" value="month">
                    <label class="btn btn-outline-primary btn-sm" for="period-month">Tháng</label>

                    <input type="radio" class="btn-check" name="chartPeriod" id="period-quarter" value="quarter">
                    <label class="btn btn-outline-primary btn-sm" for="period-quarter">Quý</label>

                    <input type="radio" class="btn-check" name="chartPeriod" id="period-year" value="year">
                    <label class="btn btn-outline-primary btn-sm" for="period-year">Năm</label>
                </div>
            </div>
            <div class="card-body p-4">
                <canvas id="revenueChart" style="max-height: 350px;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Đơn hàng gần đây -->
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Đơn hàng mới nhất</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Xem tất cả</a>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-hover align-middle">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Mã ĐH</th>
                                <th>Khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th class="text-end">Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="recent-orders-table">
                            @include('admin._partials.recent_orders_table')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal xem nhanh đơn hàng -->
<div class="modal fade" id="quickViewOrderModal" tabindex="-1" aria-labelledby="quickViewOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="quickViewOrderModalLabel"><i class="bi bi-receipt me-2"></i>Chi tiết đơn hàng</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" id="quickViewOrderBody">
                <div class="p-5 text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0">
                <a href="#" id="fullViewOrderBtn" class="btn btn-outline-primary">Mở trang chi tiết đầy đủ</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Nhúng thư viện Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. BIỂU ĐỒ DOANH THU (CHART.JS) ---
        const ctx = document.getElementById('revenueChart').getContext('2d');
        let revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: [],
                    borderColor: '#3B82F6', // primary color
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#3B82F6',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4 // Tạo đường cong mềm mại
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('vi-VN').format(context.parsed.y) + 'đ';
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN').format(value) + 'đ';
                            }
                        }
                    }
                }
            }
        });

        function fetchChartData(period) {
            fetch('{{ route("admin.dashboard.chart_data") }}?period=' + period)
                .then(response => response.json())
                .then(data => {
                    revenueChart.data.labels = data.labels;
                    revenueChart.data.datasets[0].data = data.data;
                    revenueChart.update();
                })
                .catch(error => console.error('Error fetching chart data:', error));
        }

        // Lấy dữ liệu lần đầu (Mặc định: Tuần)
        let currentPeriod = 'week';
        fetchChartData(currentPeriod);

        // Bắt sự kiện khi người dùng đổi bộ lọc (Tuần/Tháng/Quý/Năm)
        const periodRadios = document.querySelectorAll('input[name="chartPeriod"]');
        periodRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                currentPeriod = this.value;
                fetchChartData(currentPeriod);
            });
        });


        // --- 2. CẬP NHẬT THỐNG KÊ REAL-TIME (Mỗi 10s) ---
        setInterval(function() {
            // Cập nhật số liệu tổng quan
            fetch('{{ route("admin.dashboard.stats") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('stat-revenue').innerText = data.totalRevenue;
                    document.getElementById('stat-orders').innerText = data.totalOrders;
                    document.getElementById('stat-products').innerText = data.totalProducts;
                    document.getElementById('stat-users').innerText = data.totalUsers;
                    document.getElementById('recent-orders-table').innerHTML = data.tableHtml;
                })
                .catch(error => console.error('Error fetching real-time stats:', error));

            // Tự động làm mới biểu đồ (dựa trên period hiện tại)
            fetchChartData(currentPeriod);
        }, 10000); // 10s

        // --- 3. XEM NHANH ĐƠN HÀNG (AJAX MODAL) ---
        const modalBody = document.getElementById('quickViewOrderBody');
        const fullViewBtn = document.getElementById('fullViewOrderBtn');

        // Lắng nghe sự kiện click trên toàn bộ tbody (để hỗ trợ các dòng được cập nhật qua AJAX)
        document.getElementById('recent-orders-table').addEventListener('click', function(e) {
            // Kiểm tra xem nút được click có phải là nút "Xem" không
            const btn = e.target.closest('.view-order-btn');
            if (!btn) return;
            
            const orderId = btn.getAttribute('data-id');
            const fullUrl = '{{ url("admin/orders") }}/' + orderId;
            
            // Set URL cho nút "Mở trang đầy đủ"
            fullViewBtn.href = fullUrl;
            
            // Hiển thị loading spinner
            modalBody.innerHTML = '<div class="p-5 text-center"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 text-muted">Đang tải thông tin...</p></div>';
            
            // Fetch chi tiết đơn hàng
            fetch('{{ url("admin/orders") }}/' + orderId + '/modal')
                .then(response => response.text())
                .then(html => {
                    modalBody.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error fetching order details:', error);
                    modalBody.innerHTML = '<div class="p-5 text-center text-danger"><i class="bi bi-exclamation-triangle fs-1"></i><p>Không thể tải thông tin đơn hàng. Vui lòng thử lại sau.</p></div>';
                });
        });
    });
</script>
@endpush

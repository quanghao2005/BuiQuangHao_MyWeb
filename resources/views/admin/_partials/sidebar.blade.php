
    <div class="admin-sidebar bg-dark text-white p-3 vh-100">
        <h4 class="mb-4 text-uppercase text-success fw-bold">
            <i class="bi bi-speedometer2 me-2"></i>
            Admin Panel
        </h4>
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-house-door me-2"></i>
                    Dashboard
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#managementMenu">
                    <span><i class="bi bi-grid me-2"></i>Quản lý hệ thống</span>
                    <i class="bi bi-chevron-down small"></i>
                </a>

                <div class="collapse show" id="managementMenu">
                    <ul class="nav flex-column ms-3 mt-1 gap-1" style="font-size: 0.95rem;">

                        <li class="nav-item">
                            <a class="nav-link text-white-50" href="{{ route('admin.categories.index') }}">
                                <i class="bi bi-tags me-2"></i>Loại sản phẩm
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white-50" href="{{ route('admin.brands.index') }}">
                                <i class="bi bi-award me-2"></i>Thương hiệu
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white-50" href="{{ route('admin.products.index') }}">
                                <i class="bi bi-box-seam me-2"></i>Sản phẩm
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white-50" href="{{ route('admin.posts.index') }}">
                                <i class="bi bi-journal-text me-2"></i>Bài viết
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white-50" href="{{ route('admin.users.index') }}">
                                <i class="bi bi-people me-2"></i>Người dùng
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
        </ul>
    </div>

<div class="card border-0 shadow-sm">
    <div class="card-body text-center p-4">
        @if($user->avatar)
            <img src="{{ asset('uploads/avatars/' . $user->avatar) }}" alt="{{ $user->fullname }}" class="rounded-circle mb-3 border shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
        @else
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                <i class="bi bi-person-fill fs-1"></i>
            </div>
        @endif
        <h5 class="fw-bold mb-1">{{ $user->fullname }}</h5>
        <p class="text-muted small mb-0">{{ $user->email }}</p>

        <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" class="mt-3">
            @csrf
            <input type="file" name="avatar" class="form-control form-control-sm mb-2" accept="image/*" required>
            <button type="submit" class="btn btn-sm btn-outline-primary w-100"><i class="bi bi-camera me-1"></i> Cập nhật ảnh</button>
        </form>
    </div>
    <div class="list-group list-group-flush border-top">
        <a href="{{ route('profile.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('profile.index') ? 'active bg-primary border-primary' : 'border-0' }} py-3">
            <i class="bi bi-person-badge me-2"></i> Thông tin cá nhân
        </a>
        <a href="{{ route('profile.orders') }}" class="list-group-item list-group-item-action {{ request()->routeIs('profile.orders') ? 'active bg-primary border-primary' : 'border-0' }} py-3">
            <i class="bi bi-bag-check me-2"></i> Lịch sử mua hàng
        </a>
        <!-- Using tabs logic inside profile.index for security, so we link to profile with hash if not active -->
        <a href="{{ route('profile.index') }}#security" class="list-group-item list-group-item-action border-0 py-3">
            <i class="bi bi-shield-lock me-2"></i> Đổi mật khẩu
        </a>
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="list-group-item list-group-item-action border-0 py-3 text-danger w-100 text-start">
                <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
            </button>
        </form>
    </div>
</div>

@extends('client.layouts.app')
@section('title', 'Thông tin cá nhân - TechStore')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
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
                    <a href="#profile" class="list-group-item list-group-item-action active border-0 py-3" data-bs-toggle="list">
                        <i class="bi bi-person-badge me-2"></i> Thông tin cá nhân
                    </a>
                    <a href="{{ route('profile.orders') }}" class="list-group-item list-group-item-action border-0 py-3">
                        <i class="bi bi-bag-check me-2"></i> Lịch sử mua hàng
                    </a>
                    <a href="#security" class="list-group-item list-group-item-action border-0 py-3" data-bs-toggle="list">
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
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Vui lòng kiểm tra lại thông tin.
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="tab-content">
                        <!-- Tab Thông tin cá nhân -->
                        <div class="tab-pane fade show active" id="profile">
                            <h4 class="fw-bold mb-4 border-bottom pb-3">Thông tin cá nhân</h4>
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                                        <input type="text" name="fullname" class="form-control" value="{{ old('fullname', $user->fullname) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Email (Không thể thay đổi)</label>
                                        <input type="email" class="form-control text-muted bg-light" value="{{ $user->email }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Số điện thoại</label>
                                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Giới tính</label>
                                        <select name="gender" class="form-select">
                                            <option value="">-- Chọn giới tính --</option>
                                            <option value="1" {{ old('gender', $user->gender) == '1' ? 'selected' : '' }}>Nam</option>
                                            <option value="0" {{ old('gender', $user->gender) == '0' ? 'selected' : '' }}>Nữ</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Ngày sinh</label>
                                        <input type="date" name="birthday" class="form-control" value="{{ old('birthday', $user->birthday) }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Địa chỉ</label>
                                        <textarea name="address" class="form-control" rows="3">{{ old('address', $user->address) }}</textarea>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary px-4 py-2">
                                            <i class="bi bi-save me-2"></i> Lưu thay đổi
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Tab Đổi mật khẩu -->
                        <div class="tab-pane fade" id="security">
                            <h4 class="fw-bold mb-4 border-bottom pb-3">Đổi mật khẩu</h4>
                            <form action="{{ route('profile.change_password') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                                        <input type="password" name="current_password" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label fw-semibold">Mật khẩu mới <span class="text-danger">*</span></label>
                                        <input type="password" name="new_password" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label fw-semibold">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                                        <input type="password" name="new_password_confirmation" class="form-control" required>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary px-4 py-2">
                                            <i class="bi bi-key me-2"></i> Cập nhật mật khẩu
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

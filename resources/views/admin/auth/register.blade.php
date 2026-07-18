<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng ký tài khoản</title>
    {{-- Bootstrap Icons & Vite CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; background: var(--sidebar-bg); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem 0; }
        .auth-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.2); }
    </style>
</head>
<body>
    <div class="container">
        <form action="{{ route('register.post') }}" class="mx-auto p-4 p-md-5 auth-card" style="max-width: 500px;" method="POST">
            @csrf
            <h2 class="mb-4 text-center fw-bold">Đăng ký tài khoản</h2>
            
            <x-admin.alert></x-admin.alert>

            <div class="mb-3">
                <label for="f-fullname" class="form-label fw-semibold">Họ và tên</label>
                <input type="text" class="form-control @error('fullname') is-invalid @enderror" id="f-fullname" placeholder="Nhập họ và tên" name="fullname" value="{{ old('fullname') }}" required>
                @error('fullname')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="f-username" class="form-label fw-semibold">Tên đăng nhập</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="f-username" placeholder="Nhập tên đăng nhập" name="username" value="{{ old('username') }}" required>
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="f-email" class="form-label fw-semibold">Địa chỉ Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="f-email" placeholder="Nhập email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="f-phone" class="form-label fw-semibold">Số điện thoại</label>
                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="f-phone" placeholder="Nhập số điện thoại" name="phone" value="{{ old('phone') }}" required>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Giới tính</label>
                <select class="form-select @error('gender') is-invalid @enderror" name="gender" required>
                    <option value="" disabled selected>-- Chọn giới tính --</option>
                    <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>Nam</option>
                    <option value="2" {{ old('gender') == '2' ? 'selected' : '' }}>Nữ</option>
                    <option value="0" {{ old('gender') == '0' ? 'selected' : '' }}>Khác</option>
                </select>
                @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="f-password" class="form-label fw-semibold">Mật khẩu</label>
                <div class="input-group has-validation">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="f-password" placeholder="Nhập mật khẩu" name="password" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="border-color: #dee2e6;">
                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                    </button>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill">Đăng ký</button>
            
            <div class="text-center mt-4">
                <span class="text-muted">Đã có tài khoản?</span>
                <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-primary">Đăng nhập</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('f-password');
            const icon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    </script>
</body>
</html>

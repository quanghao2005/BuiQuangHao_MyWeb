<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng nhập hệ thống</title>
    {{-- Bootstrap Icons & Vite CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }
        .auth-card { 
            background: #ffffff; 
            border-radius: 1.5rem; 
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); 
            border: 1px solid rgba(255,255,255,0.1); 
            padding: 2.5rem !important;
        }
        .auth-card h2 {
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 0.5rem;
            text-align: center;
        }
        .form-control {
            padding: 0.8rem 1.2rem;
            border-radius: 0.75rem;
            border: 2px solid #e2e8f0;
            background-color: #f8fafc;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background-color: #ffffff;
        }
        .btn-primary {
            background: linear-gradient(to right, #3b82f6, #2563eb);
            border: none;
            padding: 0.8rem;
            border-radius: 0.75rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        }
        .form-label {
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.5rem;
        }
        .icon-box {
            width: 64px;
            height: 64px;
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 1.5rem auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="{{ route('login.post') }}" class="mx-auto auth-card w-100" style="max-width: 450px;" method="POST">
            @csrf
            <div class="icon-box">
                <i class="bi bi-person-circle"></i>
            </div>
            <h2>Đăng nhập hệ thống</h2>
            <p class="text-center text-muted mb-4 small">Chào mừng bạn quay trở lại TechStore.</p>
            {{-- hiển thị thông báo lỗi (nếu có) --}}
            <x-admin.alert></x-admin.alert>
            <div class="mb-3 mt-3">
                <label for="f-username" class="form-label fw-semibold">Tên đăng nhập hoặc Email</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="f-username" placeholder="Nhập tên đăng nhập hoặc email"
                    name="username" value="{{ old('username') }}">
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="f-password" class="form-label fw-semibold">Mật khẩu</label>
                <div class="input-group has-validation">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="f-password"
                        placeholder="Nhập mật khẩu" name="password"
                        value="{{ old('password') }}">
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="border-color: #dee2e6;">
                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                    </button>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-check mb-3">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember"> Ghi nhớ đăng nhập
                </label>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill">Đăng nhập</button>
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('forgotpass') }}" class="text-decoration-none">Quên mật khẩu?</a>
                <a href="{{ route('register') }}" class="text-decoration-none fw-bold text-primary">Đăng ký ngay</a>
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

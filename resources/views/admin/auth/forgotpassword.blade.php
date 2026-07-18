<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quên mật khẩu</title>
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
        .btn-outline-secondary {
            border-radius: 0.75rem;
            padding: 0.8rem;
            border: 2px solid #e2e8f0;
            color: #64748b;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-outline-secondary:hover {
            background: #f1f5f9;
            color: #334155;
            border-color: #cbd5e1;
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
        <form action="{{ route('forgotpass.post') }}" class="mx-auto auth-card w-100" style="max-width: 450px;" method="POST">
            @csrf
            <div class="icon-box">
                <i class="bi bi-envelope-check-fill"></i>
            </div>
            <h2>Quên mật khẩu</h2>
            <p class="text-center text-muted mb-4 small">Nhập email của bạn để nhận mã xác nhận OTP.</p>
            <x-admin.alert></x-admin.alert>

            <div class="mb-4 mt-3">
                <label for="f-email" class="form-label">Email đăng ký</label>
                <input type="text" class="form-control" id="f-email" placeholder="Ví dụ: example@gmail.com" name="email" value="{{ old('email') }}" autofocus>
            </div>
            
            <div class="d-flex flex-column gap-3 mt-4">
                <button type="submit" class="btn btn-primary fw-bold w-100">Gửi mã OTP</button>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary text-center">Quay lại Đăng nhập</a>
            </div>
        </form>
    </div>
</body>
</html>

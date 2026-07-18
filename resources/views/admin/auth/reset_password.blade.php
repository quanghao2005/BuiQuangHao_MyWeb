<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đặt lại mật khẩu</title>
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
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            background-color: #ffffff;
        }
        .btn-success {
            background: linear-gradient(to right, #10b981, #059669);
            border: none;
            padding: 0.8rem;
            border-radius: 0.75rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
        }
        .form-label {
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.5rem;
        }
        .icon-box {
            width: 64px;
            height: 64px;
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
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
        <form action="{{ route('forgotpass.reset.post') }}" class="mx-auto auth-card w-100" style="max-width: 450px;" method="POST">
            @csrf
            <div class="icon-box">
                <i class="bi bi-key-fill"></i>
            </div>
            <h2>Mật khẩu mới</h2>
            <p class="text-center text-muted mb-4 small">Tạo mật khẩu mới an toàn cho tài khoản của bạn.</p>
            <x-admin.alert></x-admin.alert>

            <div class="mb-3 mt-3">
                <label for="new_password" class="form-label">Mật khẩu mới</label>
                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Nhập ít nhất 6 ký tự" autofocus>
            </div>

            <div class="mb-4">
                <label for="confirm_password" class="form-label">Nhập lại mật khẩu mới</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Nhập lại chính xác mật khẩu">
            </div>
            
            <button type="submit" class="btn btn-success px-4 fw-bold rounded-pill w-100">Đổi mật khẩu & Đăng nhập</button>
        </form>
    </div>
</body>
</html>

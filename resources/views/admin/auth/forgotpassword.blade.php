<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quên mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <form action="{{ route('admin.forgotpass.post') }}" class="mx-auto shadow-sm p-4 w-50 bg-white rounded" method="POST">
            @csrf
            <h2 class="mb-4 text-center text-primary fw-bold">QUÊN MẬT KHẨU</h2>
            
            <div class="alert alert-info">
                Vui lòng nhập tên đăng nhập và email của bạn. Nếu thông tin chính xác, mật khẩu của bạn sẽ được đặt lại thành <strong>123456</strong>.
            </div>

            <x-admin.alert></x-admin.alert>
            
            <div class="mb-3">
                <label for="f-username" class="form-label fw-bold">Tên đăng nhập <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="f-username" placeholder="Nhập tên đăng nhập..." name="username" value="{{ old('username') }}">
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="f-email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="f-email" placeholder="Nhập địa chỉ email..." name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-warning w-100 py-2 fw-bold mb-3">Đặt lại mật khẩu</button>
            
            <div class="text-center">
                <a href="{{ route('admin.login') }}" class="text-decoration-none">Quay lại trang Đăng nhập</a>
            </div>
        </form>
    </div>
</body>
</html>

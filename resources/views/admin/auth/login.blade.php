<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng nhập hệ thống</title>
    {{-- CDN Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-3 ">
        <form action="{{ route('admin.login.post') }}" class="mx-auto shadow-lg p-4 w-50 bg-white" method="POST">
            @csrf
            <h2>Đăng nhập hệ thống</h2>
            {{-- hiển thị thông báo lỗi (nếu có) --}}
            <x-admin.alert></x-admin.alert>
            <div class="mb-3 mt-3">
                <label for="f-username">username</label>
                <input type="text" class="form-control" id="f-username" placeholder="nhập username"
                    name="username" value="{{ old('username') }}">
            </div>
            <div class="mb-3">
                <label for="f-password">Mật khẩu</label>
                <input type="password" class="form-control" id="f-password"
                    placeholder="nhập mật khẩu" name="password"
                    value="{{ old('password') }}">
            </div>
            <div class="form-check mb-3">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember"> Ghi nhớ đăng nhập
                </label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
            <a href="{{ route('admin.forgotpass') }}" class="mt-3 d-block">Quên mật khẩu</a>
        </form>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <nav class="navbar navbar-light bg-light admin-header">
        <div class="container-fluid">
            <span class="navbar-brand">Admin Panel</span>
            <ul class="nav align-items-center">
                @if(Auth::check())
                <li class="nav-item">
                    <span class="nav-link text-dark">Xin chào <strong>{{ Auth::user()->fullname }}</strong></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.changepass') }}">Đổi mật khẩu</a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">Đăng xuất</button>
                    </form>
                </li>
                @endif
            </ul>
        </div>
    </nav>
</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cửa Hàng Điện Tử')</title>

    {{-- CSS & JS thông qua Vite (đã bao gồm Bootstrap) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    {{-- Custom styles for Client --}}
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8f9fa; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); transition: all 0.3s ease; }
        .product-image { height: 200px; object-fit: cover; }
    </style>
</head>
<body>
    
    @include('client.partials.header')
    @include('client.partials.navbar')

    <main class="container my-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    @include('client.partials.footer')

    @stack('scripts')
</body>
</html>

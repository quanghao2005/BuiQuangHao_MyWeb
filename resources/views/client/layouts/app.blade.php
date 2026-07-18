<!DOCTYPE html>
<html lang="vi" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cửa Hàng Điện Tử')</title>

    {{-- CSS & JS thông qua Vite (đã bao gồm Bootstrap) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    {{-- SweetAlert2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.min.css" rel="stylesheet">
    
    {{-- Custom styles for Client --}}
    <style>
        body { font-family: 'Outfit', sans-serif; transition: background-color 0.3s ease; }
        [data-bs-theme="light"] body { background-color: #f3f4f6; }
        .product-card { border-radius: 1rem; overflow: hidden; transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); border: 1px solid var(--bs-border-color) !important; background: var(--bs-body-bg); }
        .product-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important; z-index: 2; }
        [data-bs-theme="dark"] .product-card:hover { box-shadow: 0 20px 40px rgba(0,0,0,0.4) !important; }
        .product-image-container { overflow: hidden; padding: 1rem; background-color: #fff; }
        .product-image { height: 200px; object-fit: contain; width: 100%; transition: transform 0.5s ease; }
        .product-card:hover .product-image { transform: scale(1.08); }
        .btn-gradient { background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%); color: white; border: none; transition: all 0.3s ease; }
        .btn-gradient:hover { opacity: 0.9; color: white; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4); }
        .section-title { font-weight: 800; font-size: 1.5rem; letter-spacing: -0.5px; position: relative; padding-left: 15px; }
        .section-title::before { content: ''; position: absolute; left: 0; top: 10%; height: 80%; width: 5px; border-radius: 5px; background: #3b82f6; }
    </style>
    
    <script>
        // Set theme immediately to avoid flash
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        }
    </script>
</head>
<body>
    
    @include('client.partials.header')

    <main class="container my-4">
        @yield('content')
    </main>

    @include('client.partials.footer')

    {{-- SweetAlert2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.all.min.js"></script>

    {{-- Global Notifications --}}
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session("success") }}'
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session("error") }}'
            });
        @endif
    </script>

    @stack('scripts')
</body>
</html>

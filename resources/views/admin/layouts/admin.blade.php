<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'My Web')</title>

    {{-- Sử dụng CSS và JavaScript thông qua Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- CDN Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    {{-- SweetAlert2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.min.css" rel="stylesheet">
    
    @stack('styles')
</head>

<body>
    <div class="container-fluid">
        <div class="row min-vh-100">
            {{-- SIDEBAR LEFT --}}
            <div class="col-md-2 bg-dark text-white p-0">
                @include('admin._partials.sidebar')
            </div>

            {{-- RIGHT CONTENT --}}
            <div class="col-md-10 d-flex flex-column p-0">
                {{-- HEADER --}}
                <div class="border-bottom bg-white">
                    @include('admin._partials.header')
                </div>

                {{-- MAIN CONTENT DYNAMIC --}}
                <main class="flex-grow-1 bg-light p-3">
                    @yield('content')
                </main>

                {{-- FOOTER --}}
                <footer class="bg-dark text-white text-center py-2">
                    @include('admin._partials.footer')
                </footer>
            </div>
        </div>
    </div>

    {{-- SweetAlert2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.all.min.js"></script>

    @stack('scripts')
    
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
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const badge = document.getElementById('sidebar-pending-orders-badge');
            
            function fetchSidebarStats() {
                fetch('{{ route("admin.sidebar_stats") }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.pendingOrders > 0) {
                            badge.innerText = data.pendingOrders;
                            badge.style.display = 'inline-block';
                        } else {
                            badge.style.display = 'none';
                        }
                    })
                    .catch(error => console.error('Error fetching sidebar stats:', error));
            }

            // Lấy dữ liệu ngay khi tải trang
            if (badge) {
                fetchSidebarStats();
                // Tự động làm mới mỗi 10 giây
                setInterval(fetchSidebarStats, 10000);
            }
        });
    </script>
</body>

</html>

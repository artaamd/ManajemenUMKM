<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Tambahkan CSRF token untuk AJAX -->
    <title>@yield('title', 'Manajemen UMKM')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logokota.png') }}">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
            margin: 0;
        }
        .container-fluid {
            display: flex;
            min-height: 100vh;
        }
         .sidebar .text-center .img-fluid {
            max-width: 40px; /* Atur lebar maksimal logo */
            height: auto; /* Tinggi akan menyesuaikan secara otomatis */
            display: block; /* Pastikan gambar dianggap sebagai blok */
            margin-left: auto; /* Atur margin kiri otomatis */
            margin-right: auto; /* Atur margin kanan otomatis */
        }
        .sidebar {
            width: 250px;
            background: #ffffff;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            padding: 20px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        .sidebar .logo img {
            height: 24px;
            width: auto;
            margin-bottom: 20px;
        }
        .sidebar .nav-link {
            color: #333;
            border-radius: 8px;
            margin: 5px 0;
            padding: 10px 15px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: #007bff;
            color: #fff;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        .content {
            margin-left: 250px;
            flex-grow: 1;
            padding: 20px;
        }
        .header {
            background: #ffffff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            transition: transform 0.2s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .btn-primary {
            border-radius: 8px;
            padding: 10px 20px;
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        .alert {
            border-radius: 8px;
        }
        .notification-bell {
            position: relative;
        }
        .notification-bell .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 0.75rem;
            padding: 2px 6px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
                transform: translateX(-200px);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
            }
            .sidebar .logo img {
                height: 20px; /* Ukuran lebih kecil untuk mobile */
            }
        }
    </style>
    <!-- Tambahkan window.chartData sebelum app.js dimuat -->
    <script>
        window.chartData = {
            labels: @json(request()->routeIs('dashboard') && auth()->user() && auth()->user()->role === 'umkm' ? ($content_trends['labels'] ?? []) : []),
            instagram: @json(request()->routeIs('dashboard') && auth()->user() && auth()->user()->role === 'umkm' ? ($content_trends['instagram'] ?? []) : []),
            facebook: @json(request()->routeIs('dashboard') && auth()->user() && auth()->user()->role === 'umkm' ? ($content_trends['facebook'] ?? []) : []),
        };
    </script>
</head>
<body>
    <div class="container-fluid">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="text-center mb-1">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('assets/img/logokota.png') }}" alt="Logo Kota" class="img-fluid">
                </a>
                <h4 class="fw-bold">Manajemen Konten Digital UMKM</h4>
            </div>
            <nav>
                <ul class="nav flex-column">
                    @if(auth()->user()->role === 'admin')
                        <!-- Sidebar untuk Admin -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="bi bi-house"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('laporan.umkm') }}" class="nav-link {{ request()->routeIs('laporan.umkm') ? 'active' : '' }}">
                                <i class="bi bi-list-ul"></i> Laporan Daftar UMKM
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('laporan.grade') }}" class="nav-link {{ request()->routeIs('laporan.grade') ? 'active' : '' }}">
                                <i class="bi bi-star"></i> Laporan Grade Konten
                            </a>
                        </li>
    
                    @else
                        <!-- Sidebar untuk UMKM -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="bi bi-house"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('konten.index') }}" class="nav-link {{ request()->routeIs('konten.*') ? 'active' : '' }}">
                                <i class="bi bi-file-earmark-text"></i> Manajemen Penjadwalan Konten
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('analitik.index') }}" class="nav-link {{ request()->routeIs('analitik.*') ? 'active' : '' }}">
                                <i class="bi bi-bar-chart"></i> Penilaian Tingkat Interaksi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('konten.preview') }}" class="nav-link {{ request()->routeIs('konten.*') ? 'active' : '' }}">
                                <i class="bi bi-eye"></i> Preview Tampilan Konten
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('umkm.profil') }}" class="nav-link {{ request()->routeIs('umkm.profil') ? 'active' : '' }}">
                                <i class="bi bi-person"></i> Profil UMKM
                            </a>
                        </li>
                    @endif
                    <li class="nav-item mt-auto">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link w-100 text-start">
                                <i class="bi bi-box-arrow-left"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="content">
            <header class="header d-flex justify-content-between align-items-center">
                <h4 class="m-0">@yield('title')</h4>
                <div class="d-flex align-items-center">
                    <div class="notification-bell me-3 position-relative">
                        <a href="#" class="nav-link" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell fs-4"></i>
                            @if (auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                                <span class="badge bg-danger rounded-circle">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @forelse (auth()->user()->unreadNotifications as $notification)
                                <li>
                                    <a class="dropdown-item" href="{{ route('konten.show', $notification->data['konten_id']) }}" data-notification-id="{{ $notification->id }}">
                                        {{ $notification->data['message'] }}
                                    </a>
                                </li>
                            @empty
                                <li><a class="dropdown-item" href="#">Tidak ada notifikasi</a></li>
                            @endforelse
                        </ul>
                    </div>
                    <div>
                        <span class="me-3">{{ auth()->user()->name }}</span>
                        <i class="bi bi-person-circle fs-4"></i>
                    </div>
                </div>
            </header>
            <main>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @yield('scripts')
    <script>
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function() {
            const notificationId = this.getAttribute('data-notification-id');
            if (notificationId) {
                fetch(`/mark-notification-as-read/${notificationId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                });
            }
        });
    });
    </script>
</body>
</html>
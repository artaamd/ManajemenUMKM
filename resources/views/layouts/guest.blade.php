<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logokota.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manajemen UMKM')</title>
    
    {{-- CUKUP GUNAKAN VITE UNTUK MEMANGGIL SEMUA ASET --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }
        /* ... sisa style kustom Anda tetap sama ... */
        .auth-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            max-width: 900px; /* Lebarkan sedikit untuk 2 kolom */
            width: 200%;
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .btn-primary {
            background: #6e8efb;
            border: none;
            transition: background 0.3s;
        }
        .btn-primary:hover {
            background: #5a78e0;
        }
        .text-primary {
            color: #6e8efb !important;
        }
        @media (max-width: 768px) {
            .auth-card {
                margin: 1rem;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
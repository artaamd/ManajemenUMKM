<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logokota.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Manajemen Konten Digital UMKM Kota Gorontalo - Platform untuk mengelola konten dan analitik bisnis Anda.">
    <meta name="author" content="Manajemen UMKM Team">
    <meta name="keywords" content="UMKM, manajemen bisnis, analitik, konten, Kota Gorontalo">
    <meta name="twitter:title" content="Manajemen Konten Digital UMKM Kota Gorontalo - Selamat Datang">
    <meta name="twitter:description" content="Platform terbaik untuk mengelola konten, menganalisis performa bisnis, dan membuat laporan dengan dukungan Dinas Tenaga Kerja, Koperasi, dan UKM Kota Gorontalo.">
    <meta name="twitter:image" content="{{ asset('assets/img/hero.png') }}">
    <meta property="og:title" content="Manajemen Konten Digital UMKM Kota Gorontalo - Selamat Datang">
    <meta property="og:site_name" content="Manajemen UMKM Kota Gorontalo">
    <meta property="og:description" content="Platform terbaik untuk mengelola konten, menganalisis performa bisnis, dan membuat laporan dengan dukungan Dinas Tenaga Kerja, Koperasi, dan UKM Kota Gorontalo.">
    <meta property="og:image" content="{{ asset('assets/img/hero.png') }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="website">
    <meta name="theme-color" content="#3b82f6">

    <title>Manajemen Konten Digital UMKM Kota Gorontalo - Selamat Datang</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css">

    <style>
        /* Brighter Aurora Gradient Background for Sections */
        .hero-bg, .features-bg, .stats-bg, .cta-bg, footer {
            background: linear-gradient(135deg, #3b82f6, #60a5fa, #a78bfa, #c4b5fd);
            background-size: 400%;
            position: relative;
            overflow: hidden;
            animation: gradientShift 7s ease infinite;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .hero-content {
            position: relative;
            z-index: 1;
        }
        /* Dynamic Header with Shrink Effect */
        header {
            background: #3b82f6; /* Match aurora base color */
            perspective: 1000px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 20;
            padding: 1.5rem 2rem;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            border: 4px solid rgba(255, 255, 255, 0.5);
            transition: padding 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        header.shrunk {
            padding: 0.25rem 0.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            transform: translateZ(3px);
        }
        header .text-3xl {
            transition: font-size 0.3s ease;
        }
        header.shrunk .text-3xl {
            font-size: 1rem;
        }
        header .cta-button {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
        }
        header.shrunk .cta-button {
            padding: 0.15rem 0.375rem;
            font-size: 0.5rem;
        }
        /* Text Color for Better Contrast on Brighter Aurora Gradient */
        .hero-bg, .features-bg, .stats-bg, .cta-bg, footer {
            color: #ffffff; /* White for better contrast */
        }
        .hero-bg h1, .features-bg h2, .stats-bg h2, .cta-bg h2, footer h4 {
            color: #ffffff; /* White for headings */
        }
        .hero-bg .text-yellow-300 {
            color: #fef3c7; /* Light yellow for highlighted text */
        }
        /* Parallax Effect */
        .parallax {
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
        }
        /* Enhanced 3D Card Effects with Glow */
        .feature-card, .stats-card {
            perspective: 1000px;
            transition: transform 0.4s ease, box-shadow 0.4s ease, border 0.4s ease;
            position: relative;
            background: linear-gradient(145deg, #ffffff, #e6e6e6);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border: 2px solid transparent;
        }
        .feature-card:hover, .stats-card:hover {
            transform: translateZ(20px) rotateX(5deg) rotateY(5deg);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2), 0 0 20px rgba(167, 139, 250, 0.5); /* Purple glow to match aurora */
            border: 2px solid #a78bfa;
        }
        .feature-card::after, .stats-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(167, 139, 250, 0.2), rgba(96, 165, 250, 0.2));
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        .feature-card:hover::after, .stats-card:hover::after {
            opacity: 1;
        }
        /* 3D Button Effects with Glow */
        .cta-button {
            perspective: 1000px;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease, color 0.3s ease;
            position: relative;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: #000000; /* Black text for buttons */
        }
        .cta-button-primary {
            background: #f6f6f6; /* Light yellow */
        }
        .cta-button-primary:hover {
            transform: translateZ(10px) scale(1.1);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3), 0 0 15px rgba(167, 139, 250, 0.5);
            background: #93c5fd; /* Light blue on hover */
            color: #000000;
        }
        .cta-button-secondary {
            background: #fef3c7; /* Light yellow */
        }
        .cta-button-secondary:hover {
            transform: translateZ(10px) scale(1.1);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3), 0 0 15px rgba(167, 139, 250, 0.5);
            background: #93c5fd;
            color: #000000;
        }
        .cta-button-tertiary {
            background: transparent;
            border: 2px solid #ffffff; /* Black border */
            color: #ffffff;
        }
        .cta-button-tertiary:hover {
            transform: translateZ(10px) scale(1.1);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3), 0 0 15px rgba(167, 139, 250, 0.5);
            background: #93c5fd;
            color: #ffffff;
        }
        /* Exception for Hero Section Buttons */
        .hero-bg .cta-button-tertiary {
            border: 2px solid #ffffff; /* White border for hero buttons */
            color: #ffffff;
        }
        .hero-bg .cta-button-tertiary:hover {
            background: #93c5fd;
            color: #ffffff;
        }
        .cta-button::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0));
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: inherit;
        }
        .cta-button:hover::after {
            opacity: 1;
        }
        /* Pulse Animation for CTA */
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: translateZ(0) scale(1); }
            50% { transform: translateZ(5px) scale(1.05); }
            100% { transform: translateZ(0) scale(1); }
        }
        /* Scroll to Top Button with Glow */
        .scroll-top {
            perspective: 1000px;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background: #fef3c7; 
            color: #000000;
        }
        .scroll-top.visible {
            opacity: 1;
        }
        .scroll-top:hover {
            transform: translateZ(10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3), 0 0 15px rgba(167, 139, 250, 0.5);
            background: #93c5fd;
            color: #000000;
        }
        /* Twinkle Star Effect for Hero Section */
        .star {
            position: absolute;
            background: #ffffff; /* White for stars */
            border-radius: 50%;
            pointer-events: none;
            animation: twinkle 3s infinite ease-in-out;
        }
        @keyframes twinkle {
            0% { transform: scale(0.2); opacity: 0; }
            50% { transform: scale(1); opacity: 1; }
            100% { transform: scale(0.2); opacity: 0; }
        }
        /* Icons Styling */
        .bi, .lni {
            color: #000000; /* Black for icons */
        }
        /* Exception for Header and Footer Icons */
        header .bi, header .lni, footer .bi, footer .lni {
            color: #ffffff; /* White for header and footer icons */
        }
        /* Hover Effect for Icons */
        .bi:hover, .lni:hover {
            color: #3b82f6; /* Bright blue on hover */
        }
        /* Hover Effect for Social Icons */
        .social-icon {
            transition: transform 0.3s ease, color 0.3s ease;
        }
        .social-icon:hover {
            transform: translateY(-5px) scale(1.2);
            color: #3b82f6; /* Bright blue on hover */
        }
        /* Remove Underlines */
        a, h1, h2, h3, h4, h5, h6, p, span {
            text-decoration: none !important;
        }
        /* Enhanced Section Borders */
        section, footer {
            transition: background 0.5s ease;
            position: relative;
            margin: 10px 0;
            padding: 10px;
        }
        section::before, footer::before {
            content: '';
            position: absolute;
            top: -6px;
            left: -6px;
            right: -6px;
            bottom: -6px;
            border: 6px solid rgba(255, 255, 255, 0.5);
            border-radius: 20px; /* Rounded corners */
            z-index: -1;
        }
        footer::before {
            display: none; /* No border for footer */
        }
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .hero-bg {
                padding: 5rem 1rem;
            }
            .hero-content h1 {
                font-size: 2.5rem;
            }
            .hero-content p {
                font-size: 1rem;
            }
            .feature-card, .stats-card {
                padding: 1.5rem;
            }
            .feature-card h3, .stats-card h3 {
                font-size: 1.5rem;
            }
            .cta-button {
                padding: 0.75rem 1.5rem;
                font-size: 0.875rem;
            }
            .navbar-menu {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #3b82f6; /* Match header */
                flex-direction: column;
                padding: 1rem;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }
            .navbar-menu a {
                padding: 0.75rem 0;
                text-align: center;
            }
            header {
                margin: 0;
                padding: 1rem 1rem;
                border: 3px solid rgba(255, 255, 255, 0.5);
            }
            header.shrunk {
                padding: 0.15rem 0.375rem;
            }
        }
        @media (max-width: 480px) {
            .hero-content h1 {
                font-size: 2rem;
            }
            .hero-content p {
                font-size: 0.875rem;
            }
            .feature-card, .stats-card {
                padding: 1rem;
            }
            .feature-card h3, .stats-card h3 {
                font-size: 1.25rem;
            }
            .cta-button {
                padding: 0.5rem 1rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body class="font-poppins bg-gray-50">
    <!-- Page Loading -->
    <div class="page-loading fixed top-0 bottom-0 left-0 right-0 z-[99999] flex items-center justify-center bg-gray-50 opacity-100 visible pointer-events-auto" role="status" aria-live="polite" aria-atomic="true" aria-label="Memuat...">
        <div class="grid-loader">
            <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
        </div>
    </div>

    <!-- Header -->
    <header>
        <div class="container mx-auto px-6 py-2 flex justify-between items-center relative">
            <div class="text-3xl font-bold text-white flex items-center">
                <i class="bi bi-building mr-3"></i> Manajemen Konten Digital UMKM Kota Gorontalo
            </div>
            <div class="flex items-center space-x-4">
                <button type="button" class="ic-navbar-toggler lg:hidden text-2xl cta-button" data-web-toggle="navbar-collapse" data-web-target="navbarMenu" aria-expanded="false" aria-label="Buka menu navigasi">
                    <i class="lni lni-menu"></i>
                </button>
                <nav id="navbarMenu" class="navbar-menu hidden lg:flex lg:items-center lg:space-x-6">
                    <a href="#features" class="text-white hover:text-fef3c7 transition duration-300">Fitur</a>
                    <a href="#stats" class="text-white hover:text-fef3c7 transition duration-300">Statistik</a>
                    <a href="{{ route('login') }}" class="cta-button-tertiary px-4 py-2 rounded-full transition duration-300">Masuk/Daftar</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero-bg py-32 md:py-40 parallax relative">
        <div class="container mx-auto px-4 text-center hero-content">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight" data-aos="fade-up">Tumbuh Bersama <span class="text-yellow-300">Manajemen Konten UMKM Kota Gorontalo</span></h1>
            <p class="text-lg md:text-xl mb-8 max-w-3xl mx-auto opacity-90" data-aos="fade-up" data-aos-delay="100">Platform terbaik untuk mengelola konten, menganalisis performa bisnis, dan membuat laporan dengan dukungan Dinas Tenaga Kerja, Koperasi, dan UKM Kota Gorontalo. Jadilah bagian dari UMKM sukses!</p>
            <div class="flex justify-center space-x-4" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('login') }}" class="cta-button cta-button-tertiary px-8 py-3 rounded-full font-semibold transition duration-300">Mulai Sekarang</a>
                <a href="#features" class="cta-button cta-button-tertiary px-8 py-3 rounded-full font-semibold transition duration-300">Pelajari Lebih Lanjut</a>
            </div>

        </div>
        <!-- Twinkle Star Background -->
        <div id="stars" class="absolute inset-0 z-0"></div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 features-bg">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-16" data-aos="fade-up">Fitur Unggulan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="feature-card p-8 bg-gray-50 rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="100">
                    <i class="bi bi-file-earmark-text text-5xl mb-4 transition-transform duration-300 hover:scale-110"></i>
                    <h3 class="text-2xl font-semibold mb-3 text-gray-800">Manajemen Konten</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Kelola postingan Instagram dan Facebook Anda dengan mudah dari satu dashboard terpusat.</p>
                    <a href="#" class="cta-button cta-button-secondary px-4 py-2 rounded-full transition duration-300">Pelajari Lebih Lanjut</a>
                </div>
                <div class="feature-card p-8 bg-gray-50 rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="200">
                    <i class="bi bi-bar-chart text-5xl mb-4 transition-transform duration-300 hover:scale-110"></i>
                    <h3 class="text-2xl font-semibold mb-3 text-gray-800">Analitik Pencapaian Konten Digital</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Pantau performa bisnis Anda dengan grading engagement rate untuk strategi terbaik.</p>
                    <a href="#" class="cta-button cta-button-secondary px-4 py-2 rounded-full transition duration-300">Pelajari Lebih Lanjut</a>
                </div>
                <div class="feature-card p-8 bg-gray-50 rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="300">
                    <i class="bi bi-eye-fill text-5xl mb-4 transition-transform duration-300 hover:scale-110"></i>
                    <h3 class="text-2xl font-semibold mb-3 text-gray-800">Preview Tampilan Konten</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Lihat pratinjau konten sebelum diposting untuk memastikan desain dan pesan sesuai target.</p>
                    <a href="#" class="cta-button cta-button-secondary px-4 py-2 rounded-full transition duration-300">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </section>


    <!-- Call to Action Section -->
    <section class="py-20 cta-bg">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-6" data-aos="fade-up">Siap untuk Memulai?</h2>
            <p class="text-lg mb-8 max-w-2xl mx-auto opacity-90" data-aos="fade-up" data-aos-delay="100">Bergabunglah dengan ratusan UMKM yang telah sukses menggunakan platform ini dengan dukungan Dinas Tenaga Kerja, Koperasi, dan UKM Kota Gorontalo.</p>
            <a href="{{ route('umkm.create') }}" class="cta-button cta-button-primary px-8 py-3 rounded-full font-semibold transition duration-300 pulse" data-aos="fade-up" data-aos-delay="200">Daftar Sekarang</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="text-2xl font-bold flex items-center mb-4">
                        <i class="bi bi-building mr-2"></i> Manajemen Konten UMKM Kota Gorontalo
                    </div>
                    <p class="text-sm opacity-80 mb-4">Kami menciptakan solusi digital untuk UMKM dengan dukungan Dinas Tenaga Kerja, Koperasi, dan UKM Kota Gorontalo.</p>
                    <div class="flex justify-start space-x-6">
                        <a href="#" class="text-2xl social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-2xl social-icon"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-2xl social-icon"><i class="bi bi-twitter"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Solusi</h4>
                    <ul>
                        <li><a href="#" class="text-white opacity-80 hover:text-fef3c7 transition duration-300">Manajemen Konten</a></li>
                        <li><a href="#" class="text-white opacity-80 hover:text-fef3c7 transition duration-300">Analitik Pencapaian</a></li>
                        <li><a href="#" class="text-white opacity-80 hover:text-fef3c7 transition duration-300">Preview Konten</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Dukungan</h4>
                    <ul>
                        <li><a href="#" class="text-white opacity-80 hover:text-fef3c7 transition duration-300">Dokumentasi</a></li>
                        <li><a href="#" class="text-white opacity-80 hover:text-fef3c7 transition duration-300">Panduan</a></li>
                        <li><a href="mailto:dukungan@umkmgorontalo.com" class="text-white opacity-80 hover:text-fef3c7 transition duration-300">Kontak Dukungan</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 text-center">
                <p class="text-sm opacity-80">© 2025 Manajemen Konten UMKM Kota Gorontalo. Hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button type="button" class="scroll-top fixed bottom-8 right-8 w-12 h-12 rounded-full flex items-center justify-center text-lg cta-button" data-web-trigger="scroll-top" aria-label="Kembali ke atas">
        <i class="lni lni-chevron-up"></i>
    </button>

    <!-- Scripts -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
        });

        // Initialize ScrollReveal
        const sr = ScrollReveal({
            origin: 'bottom',
            distance: '16px',
            duration: 1000,
            reset: false,
        });
        sr.reveal('.scroll-revealed', { cleanup: true });

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Navbar toggle
        const navbarToggler = document.querySelector('.ic-navbar-toggler');
        const navbarMenu = document.querySelector('#navbarMenu');
        navbarToggler.addEventListener('click', () => {
            navbarMenu.classList.toggle('hidden');
        });

        // Hide page loading
        window.addEventListener('load', () => {
            document.querySelector('.page-loading').classList.add('hidden');
        });

        // Scroll to top button visibility
        const scrollTopBtn = document.querySelector('.scroll-top');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollTopBtn.classList.add('visible');
            } else {
                scrollTopBtn.classList.remove('visible');
            }
        });

        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Parallax effect (simplified for performance)
        window.addEventListener('scroll', () => {
            const hero = document.querySelector('.parallax');
            const scrollPosition = window.pageYOffset;
            hero.style.backgroundPositionY = `${scrollPosition * 0.2}px`;

            // Header shrink effect
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.classList.add('shrunk');
            } else {
                header.classList.remove('shrunk');
            }
        });

        // Dynamic 3D tilt effect for cards on mouse move
        document.querySelectorAll('.feature-card, .stats-card').forEach(card => {
            card.addEventListener('mousemove', e => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                const rotateX = y / rect.height * 10;
                const rotateY = -x / rect.width * 10;
                card.style.transform = `perspective(1000px) translateZ(20px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'perspective(1000px) translateZ(0) rotateX(0) rotateY(0)';
            });

            // Touch support for mobile devices
            card.addEventListener('touchmove', e => {
                e.preventDefault();
                const touch = e.touches[0];
                const rect = card.getBoundingClientRect();
                const x = touch.clientX - rect.left - rect.width / 2;
                const y = touch.clientY - rect.top - rect.height / 2;
                const rotateX = y / rect.height * 10;
                const rotateY = -x / rect.width * 10;
                card.style.transform = `perspective(1000px) translateZ(20px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            });
            card.addEventListener('touchend', () => {
                card.style.transform = 'perspective(1000px) translateZ(0) rotateX(0) rotateY(0)';
            });
        });

        // Ensure header stays fixed
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            header.style.position = 'fixed';
            header.style.top = '0';
            header.style.background = '#3b82f6';
        });

        // Interactive stats counter animation
        const statsNumbers = document.querySelectorAll('.stats-card h3');
        statsNumbers.forEach(number => {
            const target = parseInt(number.textContent);
            let count = 0;
            const increment = target / 50;
            const updateCount = () => {
                count += increment;
                if (count < target) {
                    number.textContent = Math.ceil(count);
                    setTimeout(updateCount, 50);
                } else {
                    number.textContent = target;
                }
            };
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    updateCount();
                    observer.disconnect();
                }
            }, { threshold: 0.5 });
            observer.observe(number);
        });

        // Twinkle Star Effect for Hero Section
        const starContainer = document.getElementById('stars');
        function createStar() {
            const star = document.createElement('div');
            star.classList.add('star');
            const size = Math.random() * 3 + 1;
            star.style.width = `${size}px`;
            star.style.height = `${size}px`;
            star.style.left = `${Math.random() * 100}%`;
            star.style.top = `${Math.random() * 100}%`;
            star.style.animationDuration = `${Math.random() * 2 + 1}s`;
            star.style.animationDelay = `${Math.random() * 2}s`;
            starContainer.appendChild(star);
            setTimeout(() => star.remove(), 5000);
        }
        setInterval(createStar, 300);

        // Interactive Typewriter Effect for Hero Title
        const heroTitle = document.querySelector('.hero-content h1');
        const text = heroTitle.textContent;
        heroTitle.textContent = '';
        let index = 0;
        function typeWriter() {
            if (index < text.length) {
                heroTitle.textContent += text.charAt(index);
                index++;
                setTimeout(typeWriter, 100);
            }
        }
        window.addEventListener('load', typeWriter);

        // Mouse Trail Effect
        const trailContainer = document.createElement('div');
        trailContainer.style.position = 'fixed';
        trailContainer.style.top = '0';
        trailContainer.style.left = '0';
        trailContainer.style.width = '100%';
        trailContainer.style.height = '100%';
        trailContainer.style.pointerEvents = 'none';
        trailContainer.style.zIndex = '9999';
        document.body.appendChild(trailContainer);

        document.addEventListener('mousemove', (e) => {
            const trail = document.createElement('div');
            trail.style.position = 'absolute';
            trail.style.width = '10px';
            trail.style.height = '10px';
            trail.style.background = 'rgba(167, 139, 250, 0.5)';
            trail.style.borderRadius = '50%';
            trail.style.left = `${e.pageX - 5}px`;
            trail.style.top = `${e.pageY - 5}px`;
            trail.style.pointerEvents = 'none';
            trail.style.transition = 'all 0.5s ease';
            trail.style.transform = 'scale(1)';
            trail.style.opacity = '1';
            trailContainer.appendChild(trail);

            setTimeout(() => {
                trail.style.transform = 'scale(0)';
                trail.style.opacity = '0';
                setTimeout(() => trail.remove(), 500);
            }, 300);
        });

        // Scroll Progress Bar
        const progressBar = document.createElement('div');
        progressBar.style.position = 'fixed';
        progressBar.style.top = '0';
        progressBar.style.left = '0';
        progressBar.style.width = '0';
        progressBar.style.height = '4px';
        progressBar.style.background = 'linear-gradient(90deg, #3b82f6, #a78bfa)';
        progressBar.style.zIndex = '10000';
        document.body.appendChild(progressBar);

        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrollPercent = (scrollTop / scrollHeight) * 100;
            progressBar.style.width = `${scrollPercent}%`;
        });
    </script>
    @yield('scripts')
</body>
</html>
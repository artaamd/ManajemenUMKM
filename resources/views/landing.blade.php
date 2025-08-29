<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Manajemen Konten Digital UMKM Kota Gorontalo - Platform untuk mengelola konten dan analitik bisnis Anda.">
    <title>Manajemen Konten Digital UMKM Kota Gorontalo</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logokota.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Loading Animation */
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .animate-spin {
            animation: spin 1s linear infinite;
        }
        .animation-delay-200 {
            animation-delay: 0.2s;
        }
        .animation-delay-400 {
            animation-delay: 0.4s;
        }

        /* Motion Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.8s ease forwards;
        }
        .hero-gradient {
            background: linear-gradient(to bottom, #f5f5f7 0%, #ffffff 100%);
        }
        .nav-blur {
            backdrop-filter: saturate(180%) blur(20px);
            background-color: rgba(255, 255, 255, 0.8);
        }
        .card-hover {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            transform-origin: center bottom;
        }
        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .card-hover:hover .card-icon {
            transform: rotateY(180deg);
        }
        .card-icon {
            transition: transform 0.6s cubic-bezier(0.68, -0.6, 0.32, 1.6);
        }
        .text-gradient {
            background: linear-gradient(90deg, #2563eb 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .scroll-progress {
            height: 2px;
            background: linear-gradient(90deg, #3b82f6 0%, #60a5fa 100%);
        }
        @media (max-width: 768px) {
            .hero-height {
                min-height: 80vh;
            }
        }
    </style>
</head>
<body class="font-['Inter'] bg-white text-gray-900 antialiased">
    <!-- Loading Animation -->
    <div id="loading" class="fixed inset-0 bg-white z-50 flex items-center justify-center">
        <div class="relative w-24 h-24">
            <div class="absolute inset-0 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
            <div class="absolute inset-4 border-4 border-blue-300 border-b-transparent rounded-full animate-spin animation-delay-200"></div>
            <div class="absolute inset-8 border-4 border-blue-100 border-l-transparent rounded-full animate-spin animation-delay-400"></div>
        </div>
    </div>

    <!-- Scroll Progress -->
    <div id="scroll-progress" class="scroll-progress fixed top-0 left-0 w-0 h-0.5 z-50"></div>

    <!-- Navigation -->
    <header class="fixed w-full z-40">
        <nav class="nav-blur border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center">
                        <span class="text-xl font-semibold text-gray-900">Manajemen Konten Digital UMKM Kota Gorontalo</span>
                    </div>
                    <div class="hidden md:flex space-x-8">
                        <a href="#features" class="text-gray-600 hover:text-gray-900 transition-colors">Fitur</a>
                        <a href="#stats" class="text-gray-600 hover:text-gray-900 transition-colors">Statistik</a>
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 transition-colors">Masuk</a>
                    </div>
                    <button class="md:hidden text-gray-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-gradient pt-32 pb-20 hero-height">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-5xl md:text-6xl font-bold mb-6 fade-in" style="animation: fadeIn 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards; animation-delay: 0.1s;">
                    <span class="text-gradient">Manajemen Konten Digital</span><br>
                    UMKM Kota Gorontalo
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-10 fade-in" style="animation-delay: 0.3s;">
                    Platform terbaik untuk mengelola konten dan menganalisis performa bisnis dengan dukungan Dinas Tenaga Kerja, Koperasi, dan UKM Kota Gorontalo.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4 fade-in" style="animation-delay: 0.5s;">
                    <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-medium transition-colors">
                        Mulai Sekarang
                    </a>
                    <a href="#features" class="border border-gray-300 hover:bg-gray-50 text-gray-800 px-8 py-3 rounded-full font-medium transition-colors">
                        Pelajari Lebih Lanjut <i class="fas fa-chevron-right ml-1 text-sm"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center mb-16">Fitur Unggulan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-8 rounded-2xl card-hover">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-6 card-icon">
                        <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-3">Manajemen Konten</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Kelola postingan Instagram dan Facebook Anda dengan mudah dari satu dashboard terpusat.
                    </p>
                </div>
                <div class="bg-gray-50 p-8 rounded-2xl card-hover">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-3">Analitik Pencapaian</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Pantau performa bisnis Anda dengan Penilaian Tingkat Interaksi untuk strategi terbaik.
                    </p>
                </div>
                <div class="bg-gray-50 p-8 rounded-2xl card-hover">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-eye text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-3">Preview Konten</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Lihat pratinjau konten sebelum diposting untuk memastikan desain dan pesan sesuai target.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-6">Siap untuk Memulai?</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto mb-8">
                Bergabunglah dengan ratusan UMKM yang telah sukses menggunakan platform kami.
            </p>
            <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-medium inline-flex items-center transition-colors">
                Daftar Sekarang <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-100 border-t border-gray-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h4 class="text-lg font-semibold mb-4">UMKM Gorontalo</h4>
                    <p class="text-gray-600 text-sm">
                        Platform manajemen konten digital untuk UMKM Kota Gorontalo dengan dukungan penuh dari pemerintah daerah.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Solusi</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-gray-900 text-sm transition-colors">Manajemen Konten</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-gray-900 text-sm transition-colors">Analitik Pencapaian</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-gray-900 text-sm transition-colors">Preview Konten</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Dukungan</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-gray-900 text-sm transition-colors">Dokumentasi</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-gray-900 text-sm transition-colors">Panduan</a></li>
                        <li><a href="mailto:dukungan@umkmgorontalo.com" class="text-gray-600 hover:text-gray-900 text-sm transition-colors">Kontak Kami</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Ikuti Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-600 hover:text-gray-900 transition-colors"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-600 hover:text-gray-900 transition-colors"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-600 hover:text-gray-900 transition-colors"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200 mt-12 pt-8 text-center text-sm text-gray-500">
                © 2025 Manajemen Konten UMKM Kota Gorontalo. Hak cipta dilindungi.
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-8 right-8 w-12 h-12 bg-gray-800 text-white rounded-full flex items-center justify-center opacity-0 invisible transition-all duration-300">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script>
        // Hide loading animation when page is loaded
        window.addEventListener('load', function() {
            const loading = document.getElementById('loading');
            loading.style.opacity = '0';
            loading.style.pointerEvents = 'none';
            setTimeout(() => loading.style.display = 'none', 500);
            
            // Animate hero elements sequentially
            const heroElements = document.querySelectorAll('.hero-gradient > div > *');
            heroElements.forEach((el, i) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'opacity 0.6s cubic-bezier(0.22, 1, 0.36, 1), transform 0.6s cubic-bezier(0.22, 1, 0.36, 1)';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, 300 + (i * 150));
            });
        });

        // Scroll progress bar
        window.addEventListener('scroll', function() {
            const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
            const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrollPercent = (scrollTop / scrollHeight) * 100;
            document.getElementById('scroll-progress').style.width = scrollPercent + '%';
        });

        // Back to top button
        const backToTopButton = document.getElementById('back-to-top');
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
                backToTopButton.classList.add('opacity-100', 'visible');
            } else {
                backToTopButton.classList.remove('opacity-100', 'visible');
                backToTopButton.classList.add('opacity-0', 'invisible');
            }
        });
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Mobile menu toggle
        const mobileMenuButton = document.querySelector('button.md\\:hidden');
        mobileMenuButton.addEventListener('click', function() {
            // Implement mobile menu toggle functionality here
            alert('Mobile menu would open here in a full implementation');
        });

        // Animate elements when they come into view
        const animateOnScroll = function() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.2;
                
                if (elementPosition < screenPosition) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        };
        window.addEventListener('scroll', animateOnScroll);
        window.addEventListener('load', animateOnScroll);
    </script>
</body>
</html>
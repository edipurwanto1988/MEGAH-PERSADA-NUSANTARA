<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon -->
        @if(setting('company_logo'))
            <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . setting('company_logo')) }}">
        @else
            <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
        @endif

        <title>{{ $title ?? setting('company_name', config('app.name', 'Megah Persada Nusantara')) }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <!-- Header Navigation -->
        <header class="bg-white shadow-sm sticky top-0 z-50">
            <nav class="container mx-auto px-4 py-4">
                <div class="flex justify-between items-center">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="/" class="flex items-center space-x-2">
                            <img src="{{ asset('images/logo_megah_persada_nusantara.svg') }}" alt="{{ setting('company_name', $companyProfile->company_name ?? 'Mega Hjaya') }}" class="h-10">
                            <span class="text-xl font-bold text-gray-800">{{ setting('company_name', $companyProfile->company_name ?? 'Mega Hjaya') }}</span>
                        </a>
                    </div>
                    
                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="#home" class="text-gray-600 hover:text-blue-600 transition">Beranda</a>
                        <a href="#about" class="text-gray-600 hover:text-blue-600 transition">Tentang</a>
                        <a href="#products" class="text-gray-600 hover:text-blue-600 transition">Produk</a>
                        <a href="#articles" class="text-gray-600 hover:text-blue-600 transition">Artikel</a>
                        <a href="#contact" class="text-gray-600 hover:text-blue-600 transition">Kontak</a>
                        @guest
                            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Login</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Dashboard</a>
                        @endguest
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button id="mobile-menu-button" class="text-gray-600 hover:text-blue-600 focus:outline-none">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Mobile Navigation -->
                <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4">
                    <div class="flex flex-col space-y-3">
                        <a href="#home" class="text-gray-600 hover:text-blue-600 transition">Beranda</a>
                        <a href="#about" class="text-gray-600 hover:text-blue-600 transition">Tentang</a>
                        <a href="#products" class="text-gray-600 hover:text-blue-600 transition">Produk</a>
                        <a href="#articles" class="text-gray-600 hover:text-blue-600 transition">Artikel</a>
                        <a href="#contact" class="text-gray-600 hover:text-blue-600 transition">Kontak</a>
                        @guest
                            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-center">Login</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-center">Dashboard</a>
                        @endguest
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-12">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <div class="flex items-center space-x-2 mb-4">
                            <img src="{{ asset('images/logo_megah_persada_nusantara.svg') }}" alt="{{ setting('company_name', $companyProfile->company_name ?? 'Mega Hjaya') }}" class="h-8">
                            <span class="text-xl font-bold">{{ setting('company_name', $companyProfile->company_name ?? 'Mega Hjaya') }}</span>
                        </div>
                        <p class="text-gray-400">{{ $companyProfile->description ? substr($companyProfile->description, 0, 100) . '...' : 'Solusi Terbaik untuk Bisnis Anda' }}</p>
                    </div>
                    
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                        <ul class="space-y-2">
                            <li><a href="#home" class="text-gray-400 hover:text-white transition">Beranda</a></li>
                            <li><a href="#about" class="text-gray-400 hover:text-white transition">Tentang</a></li>
                            <li><a href="#products" class="text-gray-400 hover:text-white transition">Produk</a></li>
                            <li><a href="#articles" class="text-gray-400 hover:text-white transition">Artikel</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Layanan</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white transition">Konsultasi</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition">Pengiriman</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition">Garansi</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition">Purna Jual</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Ikuti Kami</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition">
                                <i class="fab fa-facebook text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition">
                                <i class="fab fa-instagram text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition">
                                <i class="fab fa-linkedin text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} {{ setting('company_name', $companyProfile->company_name ?? 'Megah Persada Nusantara') }}. All rights reserved | Develop by <a href="https://jasawebpekanbaru.com/ ">Jasa pembuatan Website</a></p>
                </div>
            </div>
        </footer>

        <!-- Back to Top Button -->
        <button id="back-to-top" class="fixed bottom-8 right-8 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition opacity-0 invisible">
            <i class="fas fa-arrow-up"></i>
        </button>

        <!-- Common Scripts -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Mobile Menu Toggle
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const mobileMenu = document.getElementById('mobile-menu');
                
                if (mobileMenuButton && mobileMenu) {
                    mobileMenuButton.addEventListener('click', function() {
                        mobileMenu.classList.toggle('hidden');
                    });
                }
                
                // Back to Top Button
                const backToTopButton = document.getElementById('back-to-top');
                
                if (backToTopButton) {
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
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    });
                }
                
                // Smooth Scroll for Navigation Links
                const navLinks = document.querySelectorAll('a[href^="#"]');
                
                navLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        const targetId = this.getAttribute('href').substring(1);
                        const targetElement = document.getElementById(targetId);
                        
                        if (targetElement) {
                            window.scrollTo({
                                top: targetElement.offsetTop - 80,
                                behavior: 'smooth'
                            });
                            
                            // Close mobile menu if open
                            if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                                mobileMenu.classList.add('hidden');
                            }
                        }
                    });
                });
            });
        </script>
    </body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Mega Hjaya') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
        
        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script>
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        colors: {
                            "primary": "#436fea",
                            "background-light": "#f6f6f8",
                            "background-dark": "#111521",
                        },
                        fontFamily: {
                            "display": ["Inter"]
                        },
                        borderRadius: {
                            "DEFAULT": "0.5rem",
                            "lg": "1rem",
                            "xl": "1.5rem",
                            "full": "9999px"
                        },
                    },
                },
            }
        </script>
    </head>
    <body class="bg-background-light dark:bg-background-dark font-display text-slate-800 dark:text-slate-200">
        <div class="flex flex-col min-h-screen">
            <!-- Header Navigation -->
            <header class="sticky top-0 z-50 bg-white dark:bg-background-dark/80 backdrop-blur-lg border-b border-slate-200 dark:border-slate-800">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center gap-4">
                            <a class="flex items-center gap-2" href="/">
                                <div class="text-primary">
                                    <img src="{{ asset('images/logo_megah_persada_nusantara.svg') }}" alt="{{ $companyProfile->company_name ?? 'Mega Hjaya' }}" class="h-18 w-48">
                                </div>
                            </a>
                        </div>
                        <nav class="hidden md:flex items-center gap-6">
                            
                            @php
                                $menus = \App\Models\Menu::with('children')
                                    ->whereNull('parent_id')
                                    ->orderBy('order_no')
                                    ->get();
                            @endphp
                            
                            @foreach($menus as $menu)
                                @if($menu->children->count() > 0)
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary transition-colors flex items-center gap-1">
                                            {{ $menu->menu_name }}
                                            <svg class="w-4 h-4" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        
                                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-10">
                                            <div class="py-1">
                                                @foreach($menu->children as $child)
                                                    <a href="{{ $child->getUrl() }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        {{ $child->menu_name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ $menu->getUrl() }}" class="text-sm font-medium {{ request()->url() === $menu->getUrl() ? 'text-primary dark:text-primary' : 'text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary' }} transition-colors">
                                        {{ $menu->menu_name }}
                                    </a>
                                @endif
                            @endforeach
                        </nav>
                        <div class="flex items-center gap-4">
                            <div class="relative hidden md:block">
                                <input class="w-64 pl-10 pr-4 py-2 text-sm rounded-full bg-slate-200/50 dark:bg-slate-800/50 focus:bg-white dark:focus:bg-background-dark focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Search products..." type="search"/>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="material-symbols-outlined text-slate-500">search</span>
                                </div>
                            </div>
                            <button class="md:hidden w-10 h-10 flex items-center justify-center rounded-full bg-slate-200/50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-300 hover:bg-primary/20 dark:hover:bg-primary/30 hover:text-primary dark:hover:text-primary transition-colors">
                                <span class="material-symbols-outlined">search</span>
                            </button>
                            @guest
                                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-bold rounded-lg bg-primary/10 text-primary hover:bg-primary/20 dark:bg-primary/20 dark:hover:bg-primary/30 transition-colors">Login</a>
                            @else
                                <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-bold rounded-lg bg-primary/10 text-primary hover:bg-primary/20 dark:bg-primary/20 dark:hover:bg-primary/30 transition-colors">Dashboard</a>
                            @endguest
                            <!-- Mobile menu button -->
                            <button id="mobile-menu-button" class="md:hidden w-10 h-10 flex items-center justify-center rounded-full bg-slate-200/50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-300">
                                <span class="material-symbols-outlined">menu</span>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Mobile Navigation -->
                    <div id="mobile-menu" class="hidden md:hidden pb-4">
                        <div class="flex flex-col space-y-3">
                            
                            @foreach($menus as $menu)
                                @if($menu->children->count() > 0)
                                    <div class="space-y-1">
                                        <div class="text-sm font-medium text-slate-600 dark:text-slate-300">{{ $menu->menu_name }}</div>
                                        @foreach($menu->children as $child)
                                            <a href="{{ $child->getUrl() }}" class="block pl-4 text-sm text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary transition-colors">
                                                {{ $child->menu_name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <a href="{{ $menu->getUrl() }}" class="text-sm font-medium {{ request()->url() === $menu->getUrl() ? 'text-primary dark:text-primary' : 'text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary' }} transition-colors">
                                        {{ $menu->menu_name }}
                                    </a>
                                @endif
                            @endforeach
                            
                            <a href="#about" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary transition-colors">About</a>
                            <a href="#contact" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary transition-colors">Contact</a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-background-dark border-t border-slate-200 dark:border-slate-800 mt-16">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div class="col-span-1 md:col-span-2 lg:col-span-1">
                            <div class="flex items-center gap-4">
                                <a class="flex items-center gap-2" href="/">
                                    <div class="text-primary">
                                        <img src="{{ asset('images/logo_megah_persada_nusantara.svg') }}" alt="{{ $companyProfile->company_name ?? 'Mega Hjaya' }}" class="h-18 w-48">
                                    </div>
                                </a>
                            </div>
                            <p class="text-sm text-slate-600 dark:text-slate-400">{{ $companyProfile->description ? substr($companyProfile->description, 0, 100) . '...' : 'Distributing high-quality products for a better life.' }}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-800 dark:text-slate-100 mb-4">Company</h4>
                            <ul class="space-y-2">
                                <li><a class="text-sm text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary transition-colors" href="#about">About</a></li>
                                <li><a class="text-sm text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary transition-colors" href="/products">Products</a></li>
                                <li><a class="text-sm text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary transition-colors" href="#contact">Contact</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-800 dark:text-slate-100 mb-4">Legal</h4>
                            <ul class="space-y-2">
                                <li><a class="text-sm text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary transition-colors" href="#">Privacy Policy</a></li>
                                <li><a class="text-sm text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary transition-colors" href="#">Terms of Service</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-800 dark:text-slate-100 mb-4">Follow Us</h4>
                            <div class="flex space-x-4">
                                <a class="text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary transition-colors" href="#">
                                    <svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path clip-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" fill-rule="evenodd"></path>
                                    </svg>
                                </a>
                                <a class="text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary transition-colors" href="#">
                                    <svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                                    </svg>
                                </a>
                                <a class="text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary transition-colors" href="#">
                                    <svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12.014c0 4.438 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.009-.868-.014-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.031-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.338 4.695-4.566 4.942.359.308.678.92.678 1.853 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.001 10.001 0 0022 12.014C22 6.477 17.523 2 12 2z" fill-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 border-t border-slate-200 dark:border-slate-800 pt-8 text-center text-sm text-slate-500 dark:text-slate-400">
                        <p>© {{ date('Y') }} {{ $companyProfile->company_name ?? 'Mega Hjaya' }}. All rights reserved.</p>
                    </div>
                </div>
            </footer>
        </div>

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
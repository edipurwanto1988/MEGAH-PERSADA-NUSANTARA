<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Panel' }} - {{ config('app.name', 'Megah Persada Nusantara') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1173d4",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101922",
                    },
                    fontFamily: {
                        "display": ["Inter"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
            },
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Scripts -->
</head>
<body class="font-display bg-background-light dark:bg-background-dark">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="flex flex-col w-64 bg-background-light dark:bg-background-dark border-r border-primary/20 dark:border-primary/30">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 border-b border-primary/20 dark:border-primary/30">
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('images/logo_megah_persada_nusantara.svg') }}" alt="Mega Hjaya" class="h-12 w-auto">
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 px-4 py-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary/20 dark:bg-primary/30 text-primary' : 'text-gray-700 dark:text-gray-300 hover:bg-primary/20 dark:hover:bg-primary/30 hover:text-primary' }}">
                    <span class="material-symbols-outlined mr-3">dashboard</span>
                    Dashboard
                </a>
                
                
                <a href="{{ route('admin.posts.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.posts*') ? 'bg-primary/20 dark:bg-primary/30 text-primary' : 'text-gray-700 dark:text-gray-300 hover:bg-primary/20 dark:hover:bg-primary/30 hover:text-primary' }}">
                    <span class="material-symbols-outlined mr-3">description</span>
                    Artikel
                </a>
                
                <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.products*') ? 'bg-primary/20 dark:bg-primary/30 text-primary' : 'text-gray-700 dark:text-gray-300 hover:bg-primary/20 dark:hover:bg-primary/30 hover:text-primary' }}">
                    <span class="material-symbols-outlined mr-3">inventory_2</span>
                    Produk
                </a>
                
                <a href="{{ route('admin.pages.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.pages*') ? 'bg-primary/20 dark:bg-primary/30 text-primary' : 'text-gray-700 dark:text-gray-300 hover:bg-primary/20 dark:hover:bg-primary/30 hover:text-primary' }}">
                    <span class="material-symbols-outlined mr-3">article</span>
                    Page
                </a>
                
                <a href="{{ route('admin.partners.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.partners*') ? 'bg-primary/20 dark:bg-primary/30 text-primary' : 'text-gray-700 dark:text-gray-300 hover:bg-primary/20 dark:hover:bg-primary/30 hover:text-primary' }}">
                    <span class="material-symbols-outlined mr-3">handshake</span>
                    Partners
                </a>
                
                <!-- Master Data Dropdown -->
                <div x-data="{ open: false }" @click.away="open = false" class="relative">
                    <button @click="open = !open" class="w-full flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.product-categories*') || request()->routeIs('admin.post-categories*') || request()->routeIs('admin.settings*') || request()->routeIs('admin.menus*') || request()->routeIs('admin.specifications*') || request()->routeIs('admin.sliders*') ? 'bg-primary/20 dark:bg-primary/30 text-primary' : 'text-gray-700 dark:text-gray-300 hover:bg-primary/20 dark:hover:bg-primary/30 hover:text-primary' }}">
                        <span class="material-symbols-outlined mr-3">database</span>
                        Master Data
                        <span class="ml-auto" :class="open ? 'rotate-180' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </span>
                    </button>
                    
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute left-0 top-full mt-1 w-56 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-50 overflow-hidden">
                        <div class="py-1">
                            <a href="{{ route('admin.product-categories.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.product-categories*') ? 'bg-primary/20 dark:bg-primary/30 text-primary' : 'text-gray-700 dark:text-gray-300 hover:bg-primary/20 dark:hover:bg-primary/30 hover:text-primary' }}">
                                <span class="material-symbols-outlined mr-3">category</span>
                                Kategori Produk
                            </a>
                            
                            <a href="{{ route('admin.post-categories.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.post-categories*') ? 'bg-primary/20 dark:bg-primary/30 text-primary' : 'text-gray-700 dark:text-gray-300 hover:bg-primary/20 dark:hover:bg-primary/30 hover:text-primary' }}">
                                <span class="material-symbols-outlined mr-3">article</span>
                                Kategori Artikel
                            </a>
                            
                            <a href="{{ route('admin.specifications.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.specifications*') ? 'bg-primary/20 dark:bg-primary/30 text-primary' : 'text-gray-700 dark:text-gray-300 hover:bg-primary/20 dark:hover:bg-primary/30 hover:text-primary' }}">
                                <span class="material-symbols-outlined mr-3">schema</span>
                                Spesifikasi
                            </a>
                            
                            <a href="{{ route('admin.sliders.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.sliders*') ? 'bg-primary/20 dark:bg-primary/30 text-primary' : 'text-gray-700 dark:text-gray-300 hover:bg-primary/20 dark:hover:bg-primary/30 hover:text-primary' }}">
                                <span class="material-symbols-outlined mr-3">slideshow</span>
                                Slider
                            </a>
                            
                            <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.settings') ? 'bg-primary/20 dark:bg-primary/30 text-primary' : 'text-gray-700 dark:text-gray-300 hover:bg-primary/20 dark:hover:bg-primary/30 hover:text-primary' }}">
                                <span class="material-symbols-outlined mr-3">settings</span>
                                Pengaturan
                            </a>
                            
                            <a href="{{ route('admin.menus.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.menus*') ? 'bg-primary/20 dark:bg-primary/30 text-primary' : 'text-gray-700 dark:text-gray-300 hover:bg-primary/20 dark:hover:bg-primary/30 hover:text-primary' }}">
                                <span class="material-symbols-outlined mr-3">menu</span>
                                Setting Menu
                            </a>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.users*') ? 'bg-primary/20 dark:bg-primary/30 text-primary' : 'text-gray-700 dark:text-gray-300 hover:bg-primary/20 dark:hover:bg-primary/30 hover:text-primary' }}">
                    <span class="material-symbols-outlined mr-3">people</span>
                    Pengguna
                </a>
            </nav>
            
            <!-- User Menu -->
            <div class="px-4 py-4 border-t border-primary/20 dark:border-primary/30">
                <div class="flex items-center px-4 py-2 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300">
                    <span class="material-symbols-outlined mr-3">account_circle</span>
                    {{ Auth::user()->name }}
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 hover:bg-primary/20 dark:hover:bg-primary/30 hover:text-primary">
                        <span class="material-symbols-outlined mr-3">logout</span>
                        Logout
                    </button>
                </form>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-y-auto">
            
            
            <!-- Page Content -->
            {{ $slot }}
        </main>
    </div>
    
    <!-- Dark Mode Toggle Script -->
    <script>
        // Check for saved theme preference or default to light
        const currentTheme = localStorage.getItem('theme') || 'light';
        if (currentTheme === 'dark') {
            document.documentElement.classList.add('dark');
        }
        
        // Optional: Add a theme toggle button functionality
        function toggleTheme() {
            document.documentElement.classList.toggle('dark');
            const theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            localStorage.setItem('theme', theme);
        }
    </script>
</body>
</html>
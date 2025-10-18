<x-web-layout :title="($companyName ?? $companyProfile->company_name) . ' - ' . ($companyProfile->description ? substr($companyProfile->description, 0, 50) . '...' : 'Distributing high-quality products for a better life')" :metaDescription="$metaDescription">
    <!-- Hero Section with Slider -->
    <section id="home" class="relative w-full h-[75vh] min-h-[500px] max-h-[800px] overflow-hidden lg:h-[70vh]">
        @if($sliders && $sliders->count() > 0)
            <!-- Slider Container -->
            <div class="relative w-full h-full">
                @foreach($sliders as $index => $slider)
                    <div class="slider-slide absolute inset-0 w-full h-full transition-opacity duration-1000 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" data-slide="{{ $index }}">
                        <div class="w-full h-full bg-cover bg-center" style="background-image: linear-gradient(to top, rgba(0, 0, 0, 0.5), transparent), url('{{ asset('storage/' . $slider->image_url) }}');">
                         
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Slider Indicators -->
            <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2">
                @foreach($sliders as $index => $slider)
                    <button class="slider-indicator block h-3 w-3 rounded-full {{ $index === 0 ? 'bg-white' : 'bg-white/50' }} transition-colors" data-slide="{{ $index }}"></button>
                @endforeach
            </div>
            
            <!-- Slider Navigation -->
            <button id="slider-prev" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-2 rounded-full transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button id="slider-next" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-2 rounded-full transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        @else
            <!-- Fallback Hero Section if no sliders -->
            <div class="w-full h-full bg-cover bg-center" style="background-image: linear-gradient(to top, rgba(0, 0, 0, 0.5), transparent), url('https://picsum.photos/seed/hero/1920/1080.jpg');">
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center text-white px-4">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ setting('company_name', $companyProfile->company_name ?? 'Welcome') }}</h1>
                        <p class="text-xl md:text-2xl">{{ $companyProfile->description ?? 'Discover our amazing products' }}</p>
                    </div>
                </div>
            </div>
        @endif
    </section>

    <!-- About Section -->
    <section class="bg-background-light dark:bg-background-dark py-16 sm:py-24" id="about">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="text-center max-w-4xl mx-auto">
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4 text-slate-900 dark:text-white">Tentang Kami</h2>
                    <p class="text-lg text-slate-600 dark:text-slate-400">{{ $companyProfile->description }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="bg-white dark:bg-background-dark-alt py-16 sm:py-24" id="products">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white">Produk Kami</h2>
                    <div class="flex items-center gap-2">
                        <button id="product-prev" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors">
                            <span class="material-symbols-outlined text-slate-600 dark:text-slate-300">chevron_left</span>
                        </button>
                        <button id="product-next" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors">
                            <span class="material-symbols-outlined text-slate-600 dark:text-slate-300">chevron_right</span>
                        </button>
                    </div>
                </div>
                <div class="flex overflow-x-auto no-scrollbar -mx-4 px-4 pb-8 gap-6 sm:gap-8" id="product-slider">
                    @foreach($products as $product)
                        <div class="flex-shrink-0 w-80">
                            <div class="bg-background-light dark:bg-background-dark rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300">
                                @if($product->images && $product->images->count() > 0)
                                    <div class="w-full aspect-video bg-cover bg-center" style='background-image: url("{{ Storage::url($product->images->first()->image_url) }}");'></div>
                                @else
                                    <div class="w-full aspect-video bg-cover bg-center" style='background-image: url("https://picsum.photos/seed/product{{ $product->id }}/400/300.jpg");'></div>
                                @endif
                                <div class="p-6 flex flex-col h-full">
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ $product->product_name }}</h3>
                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ Str::limit($product->description, 100) }}</p>
                                    <div class="flex-grow">
                                        @if(($product->price ?? 0) > 0 || ($product->final_price ?? 0) > 0)
                                        <div class="mt-4 flex items-baseline gap-2">
                                            <span class="text-xl font-bold text-primary">Rp {{ number_format($product->final_price ?: $product->price, 0, ',', '.') }}</span>
                                            @if($product->final_price && $product->final_price != $product->price)
                                                <span class="text-sm text-slate-500 dark:text-slate-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mt-4">
                                        <a href="/products/{{ $product->slug }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90 transition">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-8">
                    <a class="inline-block px-8 py-3 text-lg font-bold text-white bg-primary rounded-lg hover:bg-primary/90 transition-colors" href="/products">Lihat Semua Produk</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Articles Section -->
    <section class="bg-background-light dark:bg-background-dark py-16 sm:py-24" id="articles">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white">Artikel Terbaru</h2>
                    <div class="flex items-center gap-2">
                        <button id="article-prev" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors">
                            <span class="material-symbols-outlined text-slate-600 dark:text-slate-300">chevron_left</span>
                        </button>
                        <button id="article-next" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors">
                            <span class="material-symbols-outlined text-slate-600 dark:text-slate-300">chevron_right</span>
                        </button>
                    </div>
                </div>
                <div class="flex overflow-x-auto no-scrollbar -mx-4 px-4 pb-8 gap-6 sm:gap-8" id="article-slider">
                    @foreach($posts as $post)
                        <div class="flex-shrink-0 w-80">
                            <div class="bg-background-light-alt dark:bg-background-dark-alt rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300">
                                @if($post->featured_image)
                                    @if(str_starts_with($post->featured_image, 'http'))
                                        <div class="w-full aspect-video bg-cover bg-center" style='background-image: url("{{ $post->featured_image }}");'></div>
                                    @else
                                        <div class="w-full aspect-video bg-cover bg-center" style='background-image: url("{{ Storage::url($post->featured_image) }}");'></div>
                                    @endif
                                @else
                                    <div class="w-full aspect-video bg-cover bg-center" style='background-image: url("https://picsum.photos/seed/article{{ $post->id }}/800/600.jpg");'></div>
                                @endif
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ $post->title }}</h3>
                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ $post->excerpt ? Str::limit($post->excerpt, 100) : Str::limit(strip_tags($post->content), 100) }}</p>
                                    <div class="mt-4">
                                        <a href="/artikel/{{ $post->slug }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90 transition">Baca Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-8">
                    <a class="inline-block px-8 py-3 text-lg font-bold text-white bg-primary rounded-lg hover:bg-primary/90 transition-colors" href="/artikel">Lihat Semua Artikel</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="bg-white dark:bg-background-dark-alt py-16 sm:py-24" id="partners">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white">Mitra Kami</h2>
                    <div class="flex items-center gap-2">
                        <button id="partner-prev" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors">
                            <span class="material-symbols-outlined text-slate-600 dark:text-slate-300">chevron_left</span>
                        </button>
                        <button id="partner-next" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors">
                            <span class="material-symbols-outlined text-slate-600 dark:text-slate-300">chevron_right</span>
                        </button>
                    </div>
                </div>
                <div class="flex overflow-x-auto no-scrollbar -mx-4 px-4 pb-8 gap-8" id="partner-slider">
                    @foreach($partners as $partner)
                        <div class="flex-shrink-0 w-80">
                            <div class="flex flex-col items-center justify-center p-6 bg-background-light dark:bg-background-dark rounded-lg">
                                <div class="w-full h-32 bg-contain bg-center bg-no-repeat mb-4"
                                     style='background-image: url("@if($partner->logo) {{ Storage::url($partner->logo) }} @else https://picsum.photos/seed/partner{{ $partner->id }}/200/100.jpg @endif");'>
                                </div>
                                <h3 class="text-center text-sm font-medium text-slate-800 dark:text-slate-200">{{ $partner->partner_name }}</h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="bg-background-light dark:bg-background-dark py-16 sm:py-24" id="contact">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl sm:text-4xl font-bold mb-8 text-slate-900 dark:text-white text-center">Hubungi Kami</h2>
                <div class="grid md:grid-cols-2 gap-12">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Informasi Kontak</h3>
                        <p class="text-slate-600 dark:text-slate-400 mb-6">Hubungi kami untuk pertanyaan atau dukungan apa pun. Kami siap membantu Anda dengan produk dan layanan kami.</p>
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <span class="material-symbols-outlined text-primary mt-1">location_on</span>
                                <div>
                                    <h4 class="font-semibold text-slate-800 dark:text-slate-200">Alamat</h4>
                                    <p class="text-slate-600 dark:text-slate-400">{{ $siteAddress ?? $companyProfile->address }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <span class="material-symbols-outlined text-primary mt-1">phone</span>
                                <div>
                                    <h4 class="font-semibold text-slate-800 dark:text-slate-200">Telepon</h4>
                                    <p class="text-slate-600 dark:text-slate-400">{{ $companyProfile->phone }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <span class="material-symbols-outlined text-primary mt-1">email</span>
                                <div>
                                    <h4 class="font-semibold text-slate-800 dark:text-slate-200">Email</h4>
                                    <p class="text-slate-600 dark:text-slate-400">{{ $siteEmail ?? $companyProfile->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form class="space-y-4">
                        <div>
                            <label class="sr-only" for="name">Nama Anda</label>
                            <input class="form-input w-full rounded-lg border-slate-300 dark:border-slate-700 bg-background-light-alt dark:bg-background-dark-alt focus:ring-primary focus:border-primary placeholder:text-slate-400 dark:placeholder:text-slate-500" id="name" placeholder="Nama Anda" type="text"/>
                        </div>
                        <div>
                            <label class="sr-only" for="email">Email Anda</label>
                            <input class="form-input w-full rounded-lg border-slate-300 dark:border-slate-700 bg-background-light-alt dark:bg-background-dark-alt focus:ring-primary focus:border-primary placeholder:text-slate-400 dark:placeholder:text-slate-500" id="email" placeholder="Email Anda" type="email"/>
                        </div>
                        <div>
                            <label class="sr-only" for="message">Pesan Anda</label>
                            <textarea class="form-textarea w-full rounded-lg border-slate-300 dark:border-slate-700 bg-background-light-alt dark:bg-background-dark-alt focus:ring-primary focus:border-primary placeholder:text-slate-400 dark:placeholder:text-slate-500" id="message" placeholder="Pesan Anda" rows="5"></textarea>
                        </div>
                        <div class="text-right">
                            <button class="px-6 py-3 text-sm font-bold text-white bg-primary rounded-lg hover:bg-primary/90 transition-colors" type="submit">Kirim Pesan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Slider Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hero Slider
            const slides = document.querySelectorAll('.slider-slide');
            const indicators = document.querySelectorAll('.slider-indicator');
            const prevBtn = document.getElementById('slider-prev');
            const nextBtn = document.getElementById('slider-next');
            
            if (slides.length > 0) {
                let currentSlide = 0;
                
                function showSlide(index) {
                    // Hide all slides
                    slides.forEach((slide, i) => {
                        slide.classList.remove('opacity-100');
                        slide.classList.add('opacity-0');
                    });
                    
                    // Update indicators
                    indicators.forEach((indicator, i) => {
                        indicator.classList.remove('bg-white');
                        indicator.classList.add('bg-white/50');
                    });
                    
                    // Show current slide
                    slides[index].classList.remove('opacity-0');
                    slides[index].classList.add('opacity-100');
                    indicators[index].classList.remove('bg-white/50');
                    indicators[index].classList.add('bg-white');
                    
                    currentSlide = index;
                }
                
                // Next slide
                function nextSlide() {
                    const newSlide = (currentSlide + 1) % slides.length;
                    showSlide(newSlide);
                }
                
                // Previous slide
                function prevSlide() {
                    const newSlide = (currentSlide - 1 + slides.length) % slides.length;
                    showSlide(newSlide);
                }
                
                // Event listeners for navigation buttons
                if (nextBtn) nextBtn.addEventListener('click', nextSlide);
                if (prevBtn) prevBtn.addEventListener('click', prevSlide);
                
                // Event listeners for indicators
                indicators.forEach((indicator, index) => {
                    indicator.addEventListener('click', () => showSlide(index));
                });
                
                // Auto-play slider
                setInterval(nextSlide, 5000);
            }
            
            // Product Slider
            const productSlider = document.getElementById('product-slider');
            const productPrev = document.getElementById('product-prev');
            const productNext = document.getElementById('product-next');
            
            if (productSlider && productPrev && productNext) {
                productPrev.addEventListener('click', function() {
                    productSlider.scrollBy({ left: -336, behavior: 'smooth' });
                });
                
                productNext.addEventListener('click', function() {
                    productSlider.scrollBy({ left: 336, behavior: 'smooth' });
                });
            }
            
            // Article Slider
            const articleSlider = document.getElementById('article-slider');
            const articlePrev = document.getElementById('article-prev');
            const articleNext = document.getElementById('article-next');
            
            if (articleSlider && articlePrev && articleNext) {
                articlePrev.addEventListener('click', function() {
                    articleSlider.scrollBy({ left: -336, behavior: 'smooth' });
                });
                
                articleNext.addEventListener('click', function() {
                    articleSlider.scrollBy({ left: 336, behavior: 'smooth' });
                });
            }
            
            // Partner Slider
            const partnerSlider = document.getElementById('partner-slider');
            const partnerPrev = document.getElementById('partner-prev');
            const partnerNext = document.getElementById('partner-next');
            
            if (partnerSlider && partnerPrev && partnerNext) {
                partnerPrev.addEventListener('click', function() {
                    partnerSlider.scrollBy({ left: -336, behavior: 'smooth' });
                });
                
                partnerNext.addEventListener('click', function() {
                    partnerSlider.scrollBy({ left: 336, behavior: 'smooth' });
                });
            }
        });
    </script>
</x-web-layout>
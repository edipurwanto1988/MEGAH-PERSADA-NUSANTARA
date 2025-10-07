<x-web-layout :title="$companyProfile->company_name . ' - ' . ($companyProfile->description ? substr($companyProfile->description, 0, 50) . '...' : 'Distributing high-quality products for a better life')">
    <!-- Hero Section with Slider -->
    <section id="home" class="relative w-full h-[75vh] min-h-[500px] max-h-[800px] bg-cover bg-center lg:h-[70vh]" style='background-image: linear-gradient(to top, rgba(0, 0, 0, 0.5), transparent), url("https://lh3.googleusercontent.com/aida-public/AB6AXuDJRhYoD_u1sr5X8kgnecgw2qi_DVjVTGDDa5zB37cL4-ECRw2qvyph7eGMdM6li36oI8zPWlnEcRQYpR5IhlcEDFbjfz87jKzHp7L75OROr6H9f0gPkJ_08bS_rCrxYm9ZxpVJSa13zi3dN7lcgLXyRh0SKXI36Q0vJNv7MflMu1LA3HhLi1RasDM7JbcdwtM1j7XmBHPAZnazGaVGSLdEu9MksygUwmoVKHgesiglOCT7CYOPDNSuJDoFb33laP4qEpLibt3Yr8ah");'>
        <div class="absolute inset-x-0 bottom-4 flex justify-center gap-2">
            @foreach($sliders as $index => $slider)
                <span class="block h-2 w-2 rounded-full {{ $index === 0 ? 'bg-white' : 'bg-white/50' }}"></span>
            @endforeach
        </div>
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
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ $product->product_name }}</h3>
                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ Str::limit($product->description, 100) }}</p>
                                    <div class="mt-4 flex items-baseline gap-2">
                                        <span class="text-xl font-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        @if($product->final_price)
                                            <span class="text-sm text-slate-500 dark:text-slate-400 line-through">Rp {{ number_format($product->final_price, 0, ',', '.') }}</span>
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
                                        <a href="/articles/{{ $post->slug }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90 transition">Baca Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-8">
                    <a class="inline-block px-8 py-3 text-lg font-bold text-white bg-primary rounded-lg hover:bg-primary/90 transition-colors" href="/articles">Lihat Semua Artikel</a>
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
                            <div class="flex items-center justify-center p-6 bg-background-light dark:bg-background-dark rounded-lg h-40">
                                <div class="w-full h-full bg-contain bg-center bg-no-repeat" style='background-image: url("https://picsum.photos/seed/partner{{ $partner->id }}/200/100.jpg");'></div>
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
                                    <p class="text-slate-600 dark:text-slate-400">{{ $companyProfile->address }}</p>
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
                                    <p class="text-slate-600 dark:text-slate-400">{{ $companyProfile->email }}</p>
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
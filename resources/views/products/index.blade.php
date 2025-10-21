<x-web-layout :title="setting('company_name', $companyProfile->company_name) . ' - Produk'" :metaDescription="setting('meta_description')">
    <!-- Hero Section -->
    <section class="relative h-[40vh] min-h-[300px] bg-cover bg-center" style='background-image: linear-gradient(to top, rgba(0, 0, 0, 0.5), transparent), url("https://picsum.photos/seed/medical-cabinet-healthcare-storage/1920/600.jpg");'>
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">
                    @if(isset($category))
                        {{ $category->name }}
                    @else
                        Produk Kami
                    @endif
                </h1>
                <p class="text-xl text-white/90">
                    @if(isset($category))
                        Temukan produk berkualitas tinggi kategori {{ $category->name }}
                    @else
                        Temukan produk berkualitas tinggi untuk kebutuhan Anda
                    @endif
                </p>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="bg-background-light dark:bg-background-dark py-16 sm:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <!-- Categories Filter -->
                @if($categories->count() > 0)
                <div class="mb-8">
                    <div class="flex flex-wrap gap-2 justify-center">
                        <a href="/products" class="px-4 py-2 rounded-full @if(!isset($category)) bg-primary text-white @else bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 @endif hover:bg-primary/90 transition-colors">Semua</a>
                        @foreach($categories as $cat)
                            <a href="/products/category/{{ $cat->slug }}" class="px-4 py-2 rounded-full @if(isset($category) && $category->id === $cat->id) bg-primary text-white @else bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 @endif hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors">{{ $cat->name }}</a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Products Grid -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @foreach($products as $product)
                            <div class="bg-background-light-alt dark:bg-background-dark-alt rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300">
                                @if($product->images && $product->images->count() > 0)
                                    <div class="w-full aspect-video bg-cover bg-center" style='background-image: url("{{ Storage::url($product->images->first()->image_url) }}");'></div>
                                @else
                                    <div class="w-full aspect-video bg-cover bg-center" style='background-image: url("https://picsum.photos/seed/product{{ $product->id }}/400/300.jpg");'></div>
                                @endif
                                <div class="p-6 flex flex-col h-full">
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ $product->product_name }}</h3>
                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ Str::limit($product->description, 100) }}</p>
                                    @if(($product->price ?? 0) > 0 || ($product->final_price ?? 0) > 0)
                                    <div class="flex-grow mt-4 flex items-baseline gap-2">
                                        <span class="text-xl font-bold text-primary">Rp {{ number_format($product->final_price ?: $product->price, 0, ',', '.') }}</span>
                                        @if($product->final_price && $product->final_price != $product->price)
                                            <span class="text-sm text-slate-500 dark:text-slate-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                    @endif
                                    <div class="mt-4">
                                        <a href="/products/{{ $product->slug }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90 transition">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-xl text-slate-600 dark:text-slate-400">Belum ada produk yang tersedia.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-web-layout>
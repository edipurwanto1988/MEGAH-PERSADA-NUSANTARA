<x-web-layout :title="$product->product_name . ' - ' . $companyProfile->company_name">
    <main class="flex-grow bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-16">
        <div class="max-w-5xl mx-auto">
            <!-- Breadcrumb -->
            <div class="mb-6 text-sm font-medium text-slate-500 dark:text-slate-400">
                <a class="hover:text-primary" href="/products">Products</a>
                <span class="mx-2">/</span>
                <span>{{ $product->category_name }}</span>
            </div>
            
            <!-- Product Header -->
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-16">
                <!-- Product Images -->
                <div>
                    <div class="grid grid-cols-3 grid-rows-3 gap-2 aspect-[4/3] rounded-lg overflow-hidden">
                        <div class="col-span-3 row-span-2 bg-cover bg-center rounded" style='background-image: url("https://picsum.photos/seed/product{{ $product->id }}/800/600.jpg");'></div>
                        <div class="col-span-1 row-span-1 bg-cover bg-center rounded" style='background-image: url("https://picsum.photos/seed/product{{ $product->id }}-1/400/300.jpg");'></div>
                        <div class="col-span-1 row-span-1 bg-cover bg-center rounded" style='background-image: url("https://picsum.photos/seed/product{{ $product->id }}-2/400/300.jpg");'></div>
                        <div class="col-span-1 row-span-1 flex items-center justify-center bg-slate-200/50 dark:bg-slate-800/50 rounded cursor-pointer hover:bg-primary/20 dark:hover:bg-primary/30">
                            <span class="text-slate-600 dark:text-slate-300 text-xs font-bold">+3 more</span>
                        </div>
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-primary mb-2">Category: {{ $product->category->name ?? 'Uncategorized' }}</span>
                    <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">{{ $product->product_name }}</h2>
                    <p class="text-slate-600 dark:text-slate-300 mb-6">
                        {{ Str::limit($product->description, 200) }}
                    </p>
                    <button class="inline-flex items-center justify-center px-6 py-3 rounded-lg bg-primary text-white font-bold shadow-lg hover:bg-opacity-90 transition-all w-full sm:w-auto">
                        <span class="material-symbols-outlined mr-2">download</span>
                        Download E-Catalog
                    </button>
                </div>
            </div>
            
            <!-- Product Details -->
            <div class="mt-16 lg:mt-24">
                <div class="border-b border-slate-200 dark:border-slate-800 mb-8">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white pb-3 border-b-2 border-primary inline-block">Product Details</h3>
                </div>
                <div class="space-y-12">
                    <!-- Description -->
                    <div>
                        <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Description</h4>
                        <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                            {{ $product->description }}
                        </p>
                    </div>
                    
                    <!-- Key Features -->
                    <div>
                        <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Key Features</h4>
                        <div class="grid sm:grid-cols-2 gap-x-8 gap-y-4">
                            <div class="flex items-start">
                                <span class="material-symbols-outlined text-primary mt-1 mr-3">check_circle</span>
                                <div>
                                    <p class="font-semibold text-slate-800 dark:text-slate-100">High Quality</p>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">Made with premium materials</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="material-symbols-outlined text-primary mt-1 mr-3">check_circle</span>
                                <div>
                                    <p class="font-semibold text-slate-800 dark:text-slate-100">Durable</p>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">Built to last</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="material-symbols-outlined text-primary mt-1 mr-3">check_circle</span>
                                <div>
                                    <p class="font-semibold text-slate-800 dark:text-slate-100">Easy to Use</p>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">User-friendly design</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="material-symbols-outlined text-primary mt-1 mr-3">check_circle</span>
                                <div>
                                    <p class="font-semibold text-slate-800 dark:text-slate-100">Warranty</p>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">1 year warranty included</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Specifications -->
                    <div>
                        <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Specifications</h4>
                        <div class="divide-y divide-slate-200 dark:divide-slate-800 border-t border-slate-200 dark:border-slate-800">
                            <div class="py-4 grid grid-cols-3 gap-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 col-span-1">Material</p>
                                <p class="text-sm text-slate-800 dark:text-slate-200 col-span-2">Premium Quality</p>
                            </div>
                            <div class="py-4 grid grid-cols-3 gap-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 col-span-1">Dimensions</p>
                                <p class="text-sm text-slate-800 dark:text-slate-200 col-span-2">Standard Size</p>
                            </div>
                            <div class="py-4 grid grid-cols-3 gap-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 col-span-1">Weight</p>
                                <p class="text-sm text-slate-800 dark:text-slate-200 col-span-2">Lightweight</p>
                            </div>
                            <div class="py-4 grid grid-cols-3 gap-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 col-span-1">Warranty</p>
                                <p class="text-sm text-slate-800 dark:text-slate-200 col-span-2">1 Year</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
</x-web-layout>
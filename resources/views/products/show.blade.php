<x-web-layout :title="$product->product_name . ' - ' . $companyProfile->company_name" :metaDescription="Str::limit($product->description, 160)">
    <main class="flex-grow bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-16">
        <div class="max-w-5xl mx-auto">
            <!-- Breadcrumb -->
            <div class="mb-6 text-sm font-medium text-slate-500 dark:text-slate-400">
                <a class="hover:text-primary" href="/products">Products</a>
                <span class="mx-2">/</span>
                <span>{{ $product->category->category_name ?? 'Uncategorized' }}</span>
            </div>
            
            <!-- Product Header -->
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-16">
                <!-- Product Images -->
                <div>
                    @if($product->images && $product->images->count() > 0)
                        <div class="product-gallery grid grid-cols-3 grid-rows-3 gap-2 aspect-[4/3] rounded-lg overflow-hidden">
                            <!-- Main image -->
                            <div class="product-image col-span-3 row-span-2 bg-cover bg-center rounded transition-transform hover:scale-105"
                                 style='background-image: url("{{ asset('storage/' . $product->images->first()->image_url) }}");'
                                 data-image="{{ asset('storage/' . $product->images->first()->image_url) }}"
                                 title="Click to zoom and rotate"></div>
                            
                            <!-- Thumbnail images -->
                            @foreach($product->images->slice(1, 3) as $image)
                            <div class="product-image col-span-1 row-span-1 bg-cover bg-center rounded transition-transform hover:scale-105"
                                 style='background-image: url("{{ asset('storage/' . $image->image_url) }}");'
                                 data-image="{{ asset('storage/' . $image->image_url) }}"
                                 title="Click to zoom and rotate"></div>
                            @endforeach
                            
                            <!-- More images indicator if there are more than 4 images -->
                            @if($product->images->count() > 4)
                            <div class="col-span-1 row-span-1 flex items-center justify-center bg-slate-200/50 dark:bg-slate-800/50 rounded cursor-pointer hover:bg-primary/20 dark:hover:bg-primary/30">
                                <span class="text-slate-600 dark:text-slate-300 text-xs font-bold">+{{ $product->images->count() - 4 }} more</span>
                            </div>
                            @elseif($product->images->count() <= 3)
                            <!-- If less than 4 images, fill remaining slots with placeholder -->
                            @for($i = $product->images->count(); $i < 4; $i++)
                            <div class="col-span-1 row-span-1 bg-slate-200/50 dark:bg-slate-800/50 rounded"></div>
                            @endfor
                            @endif
                        </div>
                    @else
                        <!-- Fallback to placeholder if no images -->
                        <div class="product-gallery grid grid-cols-3 grid-rows-3 gap-2 aspect-[4/3] rounded-lg overflow-hidden">
                            <div class="product-image col-span-3 row-span-2 bg-cover bg-center rounded transition-transform hover:scale-105"
                                 style='background-image: url("https://picsum.photos/seed/product{{ $product->id }}/800/600.jpg");'
                                 data-image="https://picsum.photos/seed/product{{ $product->id }}/800/600.jpg"
                                 title="Click to zoom and rotate"></div>
                            <div class="product-image col-span-1 row-span-1 bg-cover bg-center rounded transition-transform hover:scale-105"
                                 style='background-image: url("https://picsum.photos/seed/product{{ $product->id }}-1/400/300.jpg");'
                                 data-image="https://picsum.photos/seed/product{{ $product->id }}-1/400/300.jpg"
                                 title="Click to zoom and rotate"></div>
                            <div class="product-image col-span-1 row-span-1 bg-cover bg-center rounded transition-transform hover:scale-105"
                                 style='background-image: url("https://picsum.photos/seed/product{{ $product->id }}-2/400/300.jpg");'
                                 data-image="https://picsum.photos/seed/product{{ $product->id }}-2/400/300.jpg"
                                 title="Click to zoom and rotate"></div>
                            <div class="col-span-1 row-span-1 bg-slate-200/50 dark:bg-slate-800/50 rounded"></div>
                        </div>
                    @endif
                    
                    <!-- Instructions for users -->
                    <div class="mt-4 text-sm text-slate-500 dark:text-slate-400">
                        <span class="material-symbols-outlined align-middle mr-1">zoom_in</span>
                        Click on any image to zoom, rotate and pan
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-primary mb-2">Category: {{ $product->category->category_name ?? 'Uncategorized' }}</span>
                    <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">{{ $product->product_name }}</h2>
                    <p class="text-slate-600 dark:text-slate-300 mb-6">
                        {{ Str::limit($product->description, 200) }}
                    </p>
                    @if($product->external_link && ($product->price > 0 || $product->final_price > 0))
                    <a href="{{ $product->external_link }}" target="_blank" class="inline-flex items-center justify-center px-6 py-3 rounded-lg bg-primary text-white font-bold shadow-lg hover:bg-opacity-90 transition-all w-full sm:w-auto">
                        <span class="material-symbols-outlined mr-2">download</span>
                        E-Catalog
                    </a>
                    @endif
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
                    
                    <!-- Specifications -->
                    <div>
                        <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Specifications</h4>
                        @if($product->specifications && $product->specifications->count() > 0)
                        <div class="divide-y divide-slate-200 dark:divide-slate-800 border-t border-slate-200 dark:border-slate-800">
                            @foreach($product->specifications as $specification)
                            <div class="py-4 grid grid-cols-3 gap-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 col-span-1">{{ $specification->spec_name }}</p>
                                <p class="text-sm text-slate-800 dark:text-slate-200 col-span-2">{{ $specification->pivot->spec_value }}</p>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-slate-600 dark:text-slate-300">No specifications available for this product.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
</x-web-layout>
<x-web-layout :title="$product->product_name . ' - ' . $companyProfile->company_name" :metaDescription="Str::limit($product->description, 160)">
    <main class="flex-grow bg-background-light dark:bg-background-dark">
        <!-- Product Gallery - Full Width -->
        <section class="relative w-full h-screen md:h-[80vh] overflow-hidden bg-white">
            @if($product->images && $product->images->count() > 0)
                <!-- Main Image Display -->
                <div class="relative w-full h-full flex items-center justify-center bg-white">
                    @foreach($product->images as $image)
                        <div class="main-image-container absolute inset-0 flex items-center justify-center {{ $loop->first ? '' : 'hidden' }}" data-index="{{ $loop->iteration - 1 }}">
                            <img src="{{ asset('storage/' . $image->image_url) }}"
                                 alt="{{ $product->product_name }}"
                                 class="max-w-full max-h-full object-contain cursor-pointer"
                                 onclick="openImageModal({{ $loop->iteration - 1 }})">
                        </div>
                    @endforeach
                </div>
                
                <!-- Gallery Thumbnails -->
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/10 to-transparent p-4">
                    <div class="flex justify-center space-x-2 overflow-x-auto pb-2">
                        @foreach($product->images as $image)
                            <div class="thumbnail-item flex-shrink-0 w-20 h-20 rounded overflow-hidden cursor-pointer transition-all @if($loop->first) ring-2 ring-white @else opacity-70 hover:opacity-100 @endif"
                                 onclick="showImage({{ $loop->iteration - 1 }})">
                                <img src="{{ asset('storage/' . $image->image_url) }}"
                                     alt="{{ $product->product_name }}"
                                     class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Gallery Controls -->
                <div class="absolute top-4 right-4 flex space-x-2">
                    <button id="gallery-zoom-in" class="p-2 rounded-full bg-white/20 hover:bg-white/30 text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path>
                        </svg>
                    </button>
                    <button id="gallery-zoom-out" class="p-2 rounded-full bg-white/20 hover:bg-white/30 text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"></path>
                        </svg>
                    </button>
                    <button id="gallery-fullscreen" class="p-2 rounded-full bg-white/20 hover:bg-white/30 text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                        </svg>
                    </button>
                </div>
            @else
                <!-- Fallback to placeholder if no images -->
                <div class="w-full h-full flex items-center justify-center">
                    <img src="https://picsum.photos/seed/product{{ $product->id }}/1200/800.jpg"
                         alt="{{ $product->product_name }}"
                         class="max-w-full max-h-full object-contain">
                </div>
            @endif
        </section>
        
        <!-- Product Info Section -->
        <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="max-w-5xl mx-auto">
                <!-- Breadcrumb -->
                <div class="mb-6 text-sm font-medium text-slate-500 dark:text-slate-400">
                    <a class="hover:text-primary" href="/products">Products</a>
                    <span class="mx-2">/</span>
                    <span>{{ $product->category->category_name ?? 'Uncategorized' }}</span>
                </div>
                
                <!-- Product Header -->
                <div class="mb-12">
                    <span class="text-sm font-medium text-primary mb-2 inline-block">Category: {{ $product->category->category_name ?? 'Uncategorized' }}</span>
                    <h1 class="text-4xl lg:text-5xl font-bold text-slate-900 dark:text-white mb-6">{{ $product->product_name }}</h1>
                
                    @if($product->external_link && ($product->price > 0 || $product->final_price > 0))
                    <a href="{{ $product->external_link }}" target="_blank" class="inline-flex items-center justify-center px-8 py-4 rounded-lg bg-primary text-white font-bold shadow-lg hover:bg-primary/90 transition-all text-lg">
                        <span class="material-symbols-outlined mr-2">download</span>
                        Download E-Catalog
                    </a>
                    @endif
                </div>
            
            <!-- Product Details -->
            <div class="mt-2 lg:mt-2">
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
                            <div class="py-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 md:col-span-1">{{ $specification->spec_name }}</p>
                                <p class="text-sm text-slate-800 dark:text-slate-200 md:col-span-2">{{ $specification->pivot->spec_value }}</p>
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
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gallery controls
        const galleryZoomIn = document.getElementById('gallery-zoom-in');
        const galleryZoomOut = document.getElementById('gallery-zoom-out');
        const galleryFullscreen = document.getElementById('gallery-fullscreen');
        const mainImageContainers = document.querySelectorAll('.main-image-container');
        const thumbnails = document.querySelectorAll('.thumbnail-item');
        
        let currentImageIndex = 0;
        let zoomLevel = 1;
        
        console.log('Main image containers found:', mainImageContainers.length);
        console.log('Thumbnails found:', thumbnails.length);
        
        // Global function to show image by index
        window.showImage = function(index) {
            if (index < 0 || index >= mainImageContainers.length) return;
            
            console.log('Showing image:', index);
            
            // Hide all image containers
            mainImageContainers.forEach(container => container.classList.add('hidden'));
            
            // Show current image container
            mainImageContainers[index].classList.remove('hidden');
            currentImageIndex = index;
            
            // Update thumbnails
            updateThumbnails(index);
        };
        
        // Update thumbnails
        function updateThumbnails(index) {
            thumbnails.forEach((thumb, i) => {
                if (i === index) {
                    thumb.classList.add('ring-2', 'ring-white');
                    thumb.classList.remove('opacity-70');
                } else {
                    thumb.classList.remove('ring-2', 'ring-white');
                    thumb.classList.add('opacity-70');
                }
            });
        }
        
        // Global function to open image modal
        window.openImageModal = function(index) {
            console.log('Opening modal for image:', index);
            createImageViewer(index);
        };
        
        // Zoom controls
        if (galleryZoomIn) {
            galleryZoomIn.addEventListener('click', () => {
                zoomLevel = Math.min(zoomLevel * 1.2, 3);
                applyZoom();
            });
        }
        
        if (galleryZoomOut) {
            galleryZoomOut.addEventListener('click', () => {
                zoomLevel = Math.max(zoomLevel / 1.2, 1);
                applyZoom();
            });
        }
        
        function applyZoom() {
            const currentContainer = mainImageContainers[currentImageIndex];
            if (currentContainer) {
                const currentImage = currentContainer.querySelector('img');
                if (currentImage) {
                    currentImage.style.transform = `scale(${zoomLevel})`;
                    currentImage.style.cursor = zoomLevel > 1 ? 'move' : 'zoom-in';
                }
            }
        }
        
        // Fullscreen toggle
        if (galleryFullscreen) {
            galleryFullscreen.addEventListener('click', () => {
                const gallerySection = document.querySelector('section');
                
                if (!document.fullscreenElement) {
                    gallerySection.requestFullscreen().catch(err => {
                        console.log(`Error attempting to enable fullscreen: ${err.message}`);
                    });
                } else {
                    document.exitFullscreen();
                }
            });
        }
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            switch(e.key) {
                case 'ArrowLeft':
                    if (currentImageIndex > 0) {
                        showImage(currentImageIndex - 1);
                    }
                    break;
                case 'ArrowRight':
                    if (currentImageIndex < mainImageContainers.length - 1) {
                        showImage(currentImageIndex + 1);
                    }
                    break;
                case '+':
                case '=':
                    zoomLevel = Math.min(zoomLevel * 1.2, 3);
                    applyZoom();
                    break;
                case '-':
                case '_':
                    zoomLevel = Math.max(zoomLevel / 1.2, 1);
                    applyZoom();
                    break;
                case 'Escape':
                    zoomLevel = 1;
                    applyZoom();
                    break;
            }
        });
        
        // Mouse wheel zoom
        const gallerySection = document.querySelector('section');
        if (gallerySection) {
            gallerySection.addEventListener('wheel', (e) => {
                if (e.ctrlKey) {
                    e.preventDefault();
                    if (e.deltaY < 0) {
                        zoomLevel = Math.min(zoomLevel * 1.1, 3);
                    } else {
                        zoomLevel = Math.max(zoomLevel / 1.1, 1);
                    }
                    applyZoom();
                }
            });
        }
        
        // Simple image viewer function
        function createImageViewer(index) {
            console.log('Creating image viewer for index:', index);
            console.log('Total images:', mainImageContainers.length);
            
            // Remove any existing viewer
            const existingViewer = document.getElementById('simple-image-viewer');
            if (existingViewer) {
                existingViewer.remove();
            }
            
            // Get all image sources
            const imageSources = [];
            mainImageContainers.forEach(container => {
                const img = container.querySelector('img');
                if (img) {
                    imageSources.push({
                        src: img.src,
                        alt: img.alt
                    });
                }
            });
            
            // Create modal overlay
            const modal = document.createElement('div');
            modal.id = 'simple-image-viewer';
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.9);
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
            `;
            
            // Create image container
            const imgContainer = document.createElement('div');
            imgContainer.style.cssText = `
                position: relative;
                max-width: 90vw;
                max-height: 90vh;
            `;
            
            // Create image
            const img = document.createElement('img');
            img.src = imageSources[index].src;
            img.alt = imageSources[index].alt;
            img.style.cssText = `
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
            `;
            
            console.log('Creating image with src:', img.src);
            
            // Create close button
            const closeBtn = document.createElement('button');
            closeBtn.innerHTML = '✕';
            closeBtn.style.cssText = `
                position: absolute;
                top: 16px;
                right: 16px;
                color: white;
                background-color: rgba(0, 0, 0, 0.5);
                border: none;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                font-size: 20px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
            `;
            
            // Create navigation buttons (only if there are multiple images)
            let prevBtn, nextBtn;
            if (imageSources.length > 1) {
                // Previous button
                prevBtn = document.createElement('button');
                prevBtn.innerHTML = '‹';
                prevBtn.style.cssText = `
                    position: absolute;
                    left: 16px;
                    top: 50%;
                    transform: translateY(-50%);
                    color: white;
                    background-color: rgba(0, 0, 0, 0.5);
                    border: none;
                    border-radius: 50%;
                    width: 40px;
                    height: 40px;
                    font-size: 24px;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                `;
                
                // Next button
                nextBtn = document.createElement('button');
                nextBtn.innerHTML = '›';
                nextBtn.style.cssText = `
                    position: absolute;
                    right: 16px;
                    top: 50%;
                    transform: translateY(-50%);
                    color: white;
                    background-color: rgba(0, 0, 0, 0.5);
                    border: none;
                    border-radius: 50%;
                    width: 40px;
                    height: 40px;
                    font-size: 24px;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                `;
                
                imgContainer.appendChild(prevBtn);
                imgContainer.appendChild(nextBtn);
            }
            
            // Create image counter
            const counter = document.createElement('div');
            counter.style.cssText = `
                position: absolute;
                bottom: 16px;
                left: 50%;
                transform: translateX(-50%);
                color: white;
                background-color: rgba(0, 0, 0, 0.5);
                padding: 8px 16px;
                border-radius: 20px;
                font-size: 14px;
            `;
            counter.textContent = `${index + 1} / ${imageSources.length}`;
            
            // Add elements to container
            imgContainer.appendChild(img);
            imgContainer.appendChild(closeBtn);
            imgContainer.appendChild(counter);
            modal.appendChild(imgContainer);
            
            // Add to body
            document.body.appendChild(modal);
            document.body.style.overflow = 'hidden';
            
            console.log('Modal added to body');
            
            // Current image index
            let currentIndex = index;
            
            // Function to update image
            function updateImage(newIndex) {
                if (newIndex < 0) newIndex = imageSources.length - 1;
                if (newIndex >= imageSources.length) newIndex = 0;
                
                currentIndex = newIndex;
                img.src = imageSources[currentIndex].src;
                img.alt = imageSources[currentIndex].alt;
                counter.textContent = `${currentIndex + 1} / ${imageSources.length}`;
                
                console.log('Updated to image:', currentIndex, img.src);
            }
            
            // Event listeners
            closeBtn.addEventListener('click', () => {
                console.log('Close button clicked');
                document.body.removeChild(modal);
                document.body.style.overflow = '';
            });
            
            if (imageSources.length > 1) {
                prevBtn.addEventListener('click', () => {
                    console.log('Previous button clicked');
                    updateImage(currentIndex - 1);
                });
                
                nextBtn.addEventListener('click', () => {
                    console.log('Next button clicked');
                    updateImage(currentIndex + 1);
                });
            }
            
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    console.log('Modal background clicked');
                    document.body.removeChild(modal);
                    document.body.style.overflow = '';
                }
            });
            
            // Keyboard navigation
            const keyHandler = (e) => {
                switch(e.key) {
                    case 'Escape':
                        console.log('Escape key pressed');
                        if (document.body.contains(modal)) {
                            document.body.removeChild(modal);
                            document.body.style.overflow = '';
                        }
                        document.removeEventListener('keydown', keyHandler);
                        break;
                    case 'ArrowLeft':
                        if (imageSources.length > 1) {
                            console.log('Left arrow pressed');
                            updateImage(currentIndex - 1);
                        }
                        break;
                    case 'ArrowRight':
                        if (imageSources.length > 1) {
                            console.log('Right arrow pressed');
                            updateImage(currentIndex + 1);
                        }
                        break;
                }
            };
            
            document.addEventListener('keydown', keyHandler);
            
            // Image load error handling
            img.addEventListener('error', () => {
                console.error('Failed to load image:', img.src);
                img.style.backgroundColor = '#333';
                img.alt = 'Failed to load image';
            });
            
            img.addEventListener('load', () => {
                console.log('Image loaded successfully');
            });
        }
    });
    </script>
</x-web-layout>
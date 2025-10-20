<x-web-layout :title="$product->product_name . ' - ' . $companyProfile->company_name" :metaDescription="Str::limit($product->description, 160)">
    <main class="flex-grow bg-background-light dark:bg-background-dark">
        <!-- Product Gallery - Proportional with Navigation -->
        <section class="relative w-full overflow-hidden bg-white">
            @if($product->images && $product->images->count() > 0)
                <!-- Main Image Display -->
                <div class="relative bg-gray-100 overflow-hidden" style="height: 500px;">
                    @if($product->images && $product->images->count() > 0)
                        @foreach($product->images as $image)
                            <div class="gallery-item {{ $loop->first ? 'block' : 'hidden' }}" data-index="{{ $loop->iteration - 1 }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                <div class="flex items-center justify-center w-full h-full p-4">
                                    <img src="{{ asset('storage/' . $image->image_url) }}"
                                         alt="{{ $product->product_name }}"
                                         style="max-width: 100%; max-height: 100%; object-fit: contain; cursor: pointer;"
                                         onclick="openImageModal({{ $loop->iteration - 1 }})"
                                         onerror="this.onerror=null; this.src='https://picsum.photos/seed/product{{ $product->id }}{{ $loop->iteration }}/800/600.jpg';">
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="flex items-center justify-center w-full h-full p-4">
                            <p class="text-gray-500">No images available for this product.</p>
                        </div>
                    @endif
                </div>
                
                <!-- Navigation Controls -->
                @if($product->images->count() > 1)
                    <div class="relative">
                        <button id="prev-btn" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-3 shadow-lg transition-all duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button id="next-btn" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-3 shadow-lg transition-all duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                @endif
                
                <!-- Thumbnail Navigation -->
                @if($product->images->count() > 1)
                    <div class="container mx-auto px-4 mt-6">
                        <div class="flex justify-center space-x-2 overflow-x-auto pb-2">
                            @foreach($product->images as $image)
                                <button class="thumbnail-btn w-20 h-20 rounded overflow-hidden border-2 {{ $loop->first ? 'border-primary' : 'border-gray-300' }} hover:border-primary transition-colors flex-shrink-0"
                                        data-index="{{ $loop->iteration - 1 }}">
                                    <img src="{{ asset('storage/' . $image->image_url) }}"
                                         alt="{{ $product->product_name }}"
                                         class="w-full h-full object-cover"
                                         onerror="this.src='https://picsum.photos/seed/product{{ $product->id }}{{ $loop->iteration }}/80/80.jpg'">
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Image Counter -->
                @if($product->images->count() > 1)
                    <div class="container mx-auto px-4">
                        <div class="text-center mt-2 text-sm text-gray-600">
                            <span id="current-index">1</span> / <span id="total-images">{{ $product->images->count() }}</span>
                        </div>
                    </div>
                @endif
            @else
                <!-- Fallback to placeholder if no images -->
                <div class="container mx-auto px-4">
                    <div class="w-full h-96 flex items-center justify-center">
                        <img src="https://picsum.photos/seed/product{{ $product->id }}/1200/800.jpg"
                             alt="{{ $product->product_name }}"
                             class="max-w-full max-h-full object-contain">
                    </div>
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
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const thumbnailBtns = document.querySelectorAll('.thumbnail-btn');
        const galleryItems = document.querySelectorAll('.gallery-item');
        const currentIndexSpan = document.getElementById('current-index');
        const totalImagesSpan = document.getElementById('total-images');
        
        let currentImageIndex = 0;
        
        console.log('Gallery items found:', galleryItems.length);
        console.log('Thumbnail buttons found:', thumbnailBtns.length);
        
        // Global function to show image by index
        window.showImage = function(index) {
            if (index < 0 || index >= galleryItems.length) return;
            
            console.log('Showing image:', index);
            
            // Hide all gallery items
            galleryItems.forEach(item => item.classList.add('hidden'));
            
            // Show current gallery item
            galleryItems[index].classList.remove('hidden');
            currentImageIndex = index;
            
            // Update image counter
            if (currentIndexSpan) {
                currentIndexSpan.textContent = index + 1;
            }
            
            // Update thumbnails
            updateThumbnails(index);
        };
        
        // Update thumbnails
        function updateThumbnails(index) {
            thumbnailBtns.forEach((btn, i) => {
                if (i === index) {
                    btn.classList.add('border-primary');
                    btn.classList.remove('border-gray-300');
                } else {
                    btn.classList.remove('border-primary');
                    btn.classList.add('border-gray-300');
                }
            });
        }
        
        // Previous button click event
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                const newIndex = currentImageIndex > 0 ? currentImageIndex - 1 : galleryItems.length - 1;
                showImage(newIndex);
            });
        }
        
        // Next button click event
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                const newIndex = currentImageIndex < galleryItems.length - 1 ? currentImageIndex + 1 : 0;
                showImage(newIndex);
            });
        }
        
        // Thumbnail button click events
        thumbnailBtns.forEach((btn, index) => {
            btn.addEventListener('click', () => {
                showImage(index);
            });
        });
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            switch(e.key) {
                case 'ArrowLeft':
                    if (currentImageIndex > 0) {
                        showImage(currentImageIndex - 1);
                    }
                    break;
                case 'ArrowRight':
                    if (currentImageIndex < galleryItems.length - 1) {
                        showImage(currentImageIndex + 1);
                    }
                    break;
            }
        });
        
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
            
            // Get all gallery images
            const galleryImages = document.querySelectorAll('.gallery-item img');
            console.log('Total gallery images found:', galleryImages.length);
            
            // Get all image sources
            const imageSources = [];
            galleryImages.forEach(img => {
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
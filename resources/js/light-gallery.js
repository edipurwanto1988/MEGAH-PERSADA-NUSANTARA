class LightGallery {
    constructor(container, options = {}) {
        this.container = typeof container === 'string' ? document.querySelector(container) : container;
        this.options = {
            ...{
                thumbnail: true,
                zoom: true,
                fullscreen: true,
                download: false,
                counter: true,
                autoplay: false,
                autoplaySpeed: 3000,
                preload: 2,
                animateThumb: true,
                showThumbByDefault: true,
                pullCaptionUp: true,
                thumbnailHeight: 80,
                thumbnailWidth: 80,
                plugins: [],
                mode: 'lg-slide',
                cssEasing: 'cubic-bezier(0.25, 0, 0.25, 1)',
                speed: 600,
                ...options
            }
        };
        
        this.items = [];
        this.currentIndex = 0;
        this.galleryItems = [];
        this.dynamicEl = [];
        this.galleryContainer = null;
        this.init();
    }
    
    init() {
        this.buildItems();
        if (this.galleryItems.length > 0) {
            this.buildGallery();
            this.buildStructure();
            this.bindEvents();
        }
    }
    
    buildItems() {
        const items = this.container.querySelectorAll('.gallery-item');
        
        items.forEach((item, index) => {
            const href = item.getAttribute('href');
            const src = item.getAttribute('data-src') || href;
            const subHtml = item.getAttribute('data-sub-html') || '';
            const poster = item.querySelector('img')?.getAttribute('src') || '';
            
            this.galleryItems.push({
                src: src,
                thumb: poster,
                subHtml: subHtml,
                index: index
            });
        });
    }
    
    buildGallery() {
        // Create gallery container
        this.galleryContainer = document.createElement('div');
        this.galleryContainer.className = 'lg-container';
        this.galleryContainer.id = 'lg-gallery';
        
        // Create gallery structure
        this.galleryContainer.innerHTML = `
            <div class="lg-backdrop"></div>
            <div class="lg-outer">
                <div class="lg-content">
                    <div class="lg-inner">
                        <!-- Gallery items will be added here -->
                    </div>
                    <div class="lg-toolbar">
                        <div class="lg-icon lg-icon-close"></div>
                        <div class="lg-icon lg-icon-download"></div>
                        <div class="lg-icon lg-icon-fullscreen"></div>
                        <div class="lg-icon lg-icon-zoom-in"></div>
                        <div class="lg-icon lg-icon-zoom-out"></div>
                    </div>
                    <div class="lg-sub-html"></div>
                    <div class="lg-counter">
                        <span class="lg-counter-current">1</span> / <span class="lg-counter-all">1</span>
                    </div>
                </div>
                <div class="lg-thumb-outer">
                    <div class="lg-thumb-group">
                        <!-- Thumbnails will be added here -->
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(this.galleryContainer);
    }
    
    buildStructure() {
        this.backdrop = this.galleryContainer.querySelector('.lg-backdrop');
        this.outer = this.galleryContainer.querySelector('.lg-outer');
        this.content = this.galleryContainer.querySelector('.lg-content');
        this.inner = this.galleryContainer.querySelector('.lg-inner');
        this.subHtml = this.galleryContainer.querySelector('.lg-sub-html');
        this.toolbar = this.galleryContainer.querySelector('.lg-toolbar');
        this.counter = this.galleryContainer.querySelector('.lg-counter');
        this.thumbOuter = this.galleryContainer.querySelector('.lg-thumb-outer');
        this.thumbGroup = this.galleryContainer.querySelector('.lg-thumb-group');
        
        // Build thumbnails
        this.buildThumbnails();
        
        // Build items
        this.buildGalleryItems();
    }
    
    buildThumbnails() {
        if (!this.thumbGroup) return;
        
        this.thumbGroup.innerHTML = '';
        
        this.galleryItems.forEach((item, index) => {
            const thumbItem = document.createElement('div');
            thumbItem.className = `lg-thumb-item ${index === 0 ? 'lg-current' : ''}`;
            thumbItem.setAttribute('data-index', index);
            
            const thumbImg = document.createElement('img');
            thumbImg.src = item.thumb;
            thumbImg.alt = `Thumbnail ${index + 1}`;
            
            thumbItem.appendChild(thumbImg);
            this.thumbGroup.appendChild(thumbItem);
        });
    }
    
    buildGalleryItems() {
        if (!this.inner) return;
        
        this.inner.innerHTML = '';
        
        this.galleryItems.forEach((item, index) => {
            const itemEl = document.createElement('div');
            itemEl.className = `lg-item ${index === 0 ? 'lg-current' : ''}`;
            itemEl.setAttribute('data-index', index);
            
            const img = document.createElement('img');
            img.src = item.src;
            img.alt = `Gallery image ${index + 1}`;
            img.className = 'lg-object lg-image';
            
            itemEl.appendChild(img);
            this.inner.appendChild(itemEl);
        });
    }
    
    bindEvents() {
        if (!this.galleryContainer) return;
        
        // Gallery item clicks
        const items = this.container.querySelectorAll('.gallery-item');
        items.forEach((item, index) => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                this.openGallery(index);
            });
        });
        
        // Gallery controls
        this.bindGalleryControls();
        
        // Keyboard events
        this.bindKeyboardEvents();
        
        // Touch events
        this.bindTouchEvents();
    }
    
    bindGalleryControls() {
        if (!this.galleryContainer) return;
        
        // Close button
        const closeBtn = this.galleryContainer.querySelector('.lg-icon-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => this.closeGallery());
        }
        
        // Zoom controls
        const zoomInBtn = this.galleryContainer.querySelector('.lg-icon-zoom-in');
        const zoomOutBtn = this.galleryContainer.querySelector('.lg-icon-zoom-out');
        
        if (zoomInBtn) {
            zoomInBtn.addEventListener('click', () => this.zoom(1.1));
        }
        
        if (zoomOutBtn) {
            zoomOutBtn.addEventListener('click', () => this.zoom(0.9));
        }
        
        // Fullscreen
        const fullscreenBtn = this.galleryContainer.querySelector('.lg-icon-fullscreen');
        if (fullscreenBtn) {
            fullscreenBtn.addEventListener('click', () => this.toggleFullscreen());
        }
        
        // Download
        const downloadBtn = this.galleryContainer.querySelector('.lg-icon-download');
        if (downloadBtn) {
            downloadBtn.addEventListener('click', () => this.downloadImage());
        }
        
        // Backdrop click
        if (this.backdrop) {
            this.backdrop.addEventListener('click', () => this.closeGallery());
        }
        
        // Thumbnail clicks in gallery
        if (this.thumbGroup) {
            const thumbItems = this.thumbGroup.querySelectorAll('.lg-thumb-item');
            thumbItems.forEach((thumb, index) => {
                thumb.addEventListener('click', () => {
                    this.goToSlide(index);
                });
            });
        }
    }
    
    bindKeyboardEvents() {
        document.addEventListener('keydown', (e) => {
            if (!this.galleryContainer || !this.galleryContainer.classList.contains('lg-open')) return;
            
            switch(e.key) {
                case 'Escape':
                    this.closeGallery();
                    break;
                case 'ArrowLeft':
                    this.prevSlide();
                    break;
                case 'ArrowRight':
                    this.nextSlide();
                    break;
                case '+':
                case '=':
                    this.zoom(1.1);
                    break;
                case '-':
                case '_':
                    this.zoom(0.9);
                    break;
            }
        });
    }
    
    bindTouchEvents() {
        if (!this.content) return;
        
        let touchStartX = 0;
        let touchEndX = 0;
        
        this.content.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });
        
        this.content.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            this.handleSwipe(touchStartX, touchEndX);
        });
    }
    
    handleSwipe(startX, endX) {
        const swipeThreshold = 50;
        const diff = startX - endX;
        
        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                this.nextSlide();
            } else {
                this.prevSlide();
            }
        }
    }
    
    openGallery(index = 0) {
        if (!this.galleryContainer) return;
        
        this.currentIndex = index;
        this.galleryContainer.classList.add('lg-open');
        document.body.style.overflow = 'hidden';
        
        this.showImage(index);
        this.updateCounter();
        this.updateThumbnails(index);
        this.updateSubHtml(index);
    }
    
    closeGallery() {
        if (!this.galleryContainer) return;
        
        this.galleryContainer.classList.remove('lg-open');
        document.body.style.overflow = '';
        
        // Reset zoom
        this.resetZoom();
    }
    
    showImage(index) {
        if (!this.inner) return;
        
        const items = this.inner.querySelectorAll('.lg-item');
        
        // Hide all images
        items.forEach(item => item.classList.remove('lg-current'));
        
        // Show current image
        if (items[index]) {
            items[index].classList.add('lg-current');
        }
        
        this.currentIndex = index;
        this.updateCounter();
        this.updateSubHtml(index);
    }
    
    updateThumbnails(index) {
        // Update gallery thumbnails
        if (this.thumbGroup) {
            const galleryThumbnails = this.thumbGroup.querySelectorAll('.lg-thumb-item');
            galleryThumbnails.forEach((thumb, i) => {
                if (i === index) {
                    thumb.classList.add('lg-current');
                } else {
                    thumb.classList.remove('lg-current');
                }
            });
        }
        
        // Update gallery items
        if (this.inner) {
            const items = this.inner.querySelectorAll('.lg-item');
            items.forEach((item, i) => {
                if (i === index) {
                    item.classList.add('lg-current');
                } else {
                    item.classList.remove('lg-current');
                }
            });
        }
    }
    
    updateCounter() {
        if (!this.counter) return;
        
        const current = this.counter.querySelector('.lg-counter-current');
        const all = this.counter.querySelector('.lg-counter-all');
        
        if (current) current.textContent = this.currentIndex + 1;
        if (all) all.textContent = this.galleryItems.length;
    }
    
    updateSubHtml(index) {
        if (!this.subHtml) return;
        
        const item = this.galleryItems[index];
        this.subHtml.innerHTML = item.subHtml || '';
    }
    
    nextSlide() {
        const nextIndex = (this.currentIndex + 1) % this.galleryItems.length;
        this.goToSlide(nextIndex);
    }
    
    prevSlide() {
        const prevIndex = (this.currentIndex - 1 + this.galleryItems.length) % this.galleryItems.length;
        this.goToSlide(prevIndex);
    }
    
    goToSlide(index) {
        this.currentIndex = index;
        this.showImage(index);
        this.updateThumbnails(index);
    }
    
    zoom(factor) {
        if (!this.inner) return;
        
        const currentItem = this.inner.querySelector('.lg-item.lg-current');
        if (!currentItem) return;
        
        const img = currentItem.querySelector('.lg-image');
        if (!img) return;
        
        const currentScale = img.style.transform ?
            parseFloat(img.style.transform.match(/scale\(([\d.]+)\)/)?.[1] || 1) : 1;
        
        const newScale = Math.min(Math.max(currentScale * factor, 0.5), 3);
        
        img.style.transform = `scale(${newScale})`;
    }
    
    resetZoom() {
        if (!this.inner) return;
        
        const img = this.inner.querySelector('.lg-item.lg-current .lg-image');
        if (img) {
            img.style.transform = 'scale(1)';
        }
    }
    
    toggleFullscreen() {
        if (!this.galleryContainer) return;
        
        if (!document.fullscreenElement) {
            this.galleryContainer.requestFullscreen().catch(err => {
                console.log(`Error attempting to enable fullscreen: ${err.message}`);
            });
        } else {
            document.exitFullscreen();
        }
    }
    
    downloadImage() {
        const item = this.galleryItems[this.currentIndex];
        const link = document.createElement('a');
        link.href = item.src;
        link.download = `product-image-${this.currentIndex + 1}.jpg`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Auto-initialize light gallery if there's a lightgallery container
    const lightGalleryContainer = document.getElementById('lightgallery');
    if (lightGalleryContainer) {
        new LightGallery(lightGalleryContainer);
    }
});

// Export for manual initialization
window.LightGallery = LightGallery;
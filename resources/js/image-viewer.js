class ImageViewer {
    constructor(container, images = []) {
        this.container = typeof container === 'string' ? document.querySelector(container) : container;
        this.images = images;
        this.currentIndex = 0;
        this.zoom = 1;
        this.rotation = 0;
        this.isDragging = false;
        this.startX = 0;
        this.startY = 0;
        this.translateX = 0;
        this.translateY = 0;
        
        this.init();
    }
    
    init() {
        // Create modal overlay if it doesn't exist
        if (!document.getElementById('image-viewer-modal')) {
            this.createModal();
        }
        
        // Extract images from the container if not provided
        if (this.images.length === 0 && this.container) {
            this.extractImagesFromContainer();
        }
        
        // Add click events to images
        this.addImageClickEvents();
        
        // Add keyboard events
        this.addKeyboardEvents();
    }
    
    extractImagesFromContainer() {
        if (!this.container) return;
        
        const imageElements = this.container.querySelectorAll('.product-image');
        this.images = Array.from(imageElements).map(img => {
            // Try to get image from data-image attribute first, then from background-image style
            if (img.dataset.image) {
                return img.dataset.image;
            } else {
                const bgImage = img.style.backgroundImage;
                return bgImage.slice(5, -2); // Remove url(" and ")
            }
        });
    }
    
    createModal() {
        const modal = document.createElement('div');
        modal.id = 'image-viewer-modal';
        modal.className = 'fixed inset-0 bg-black bg-opacity-90 z-50 hidden flex items-center justify-center';
        modal.innerHTML = `
            <div class="relative w-full h-full flex flex-col">
                <!-- Header with controls -->
                <div class="flex justify-between items-center p-4 text-white">
                    <div class="flex items-center space-x-4">
                        <button id="zoom-out-btn" class="p-2 rounded-full bg-white bg-opacity-20 hover:bg-opacity-30 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"></path>
                            </svg>
                        </button>
                        <button id="zoom-in-btn" class="p-2 rounded-full bg-white bg-opacity-20 hover:bg-opacity-30 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path>
                            </svg>
                        </button>
                        <button id="rotate-left-btn" class="p-2 rounded-full bg-white bg-opacity-20 hover:bg-opacity-30 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4v5h5M6 9a9 9 0 0111.5 5.5"></path>
                            </svg>
                        </button>
                        <button id="rotate-right-btn" class="p-2 rounded-full bg-white bg-opacity-20 hover:bg-opacity-30 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 20v-5h-5M18 15a9 9 0 01-11.5-5.5"></path>
                            </svg>
                        </button>
                        <button id="reset-btn" class="p-2 rounded-full bg-white bg-opacity-20 hover:bg-opacity-30 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </button>
                        <span class="text-sm">Zoom: <span id="zoom-level">100%</span></span>
                    </div>
                    <button id="close-modal-btn" class="p-2 rounded-full bg-white bg-opacity-20 hover:bg-opacity-30 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Image container -->
                <div class="flex-1 relative overflow-hidden flex items-center justify-center">
                    <img id="modal-image" src="" alt="Product Image" class="max-w-full max-h-full object-contain cursor-move transition-transform duration-200">
                </div>
                
                <!-- Image thumbnails -->
                <div id="thumbnails-container" class="flex justify-center space-x-2 p-4 overflow-x-auto">
                    <!-- Thumbnails will be added dynamically -->
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Add event listeners to modal controls
        this.addModalEventListeners();
    }
    
    addModalEventListeners() {
        const modal = document.getElementById('image-viewer-modal');
        const modalImage = document.getElementById('modal-image');
        const zoomInBtn = document.getElementById('zoom-in-btn');
        const zoomOutBtn = document.getElementById('zoom-out-btn');
        const rotateLeftBtn = document.getElementById('rotate-left-btn');
        const rotateRightBtn = document.getElementById('rotate-right-btn');
        const resetBtn = document.getElementById('reset-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        
        // Close modal
        closeModalBtn.addEventListener('click', () => this.closeModal());
        
        // Close modal on background click
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                this.closeModal();
            }
        });
        
        // Zoom controls
        zoomInBtn.addEventListener('click', () => this.zoomIn());
        zoomOutBtn.addEventListener('click', () => this.zoomOut());
        
        // Rotation controls
        rotateLeftBtn.addEventListener('click', () => this.rotateLeft());
        rotateRightBtn.addEventListener('click', () => this.rotateRight());
        
        // Reset button
        resetBtn.addEventListener('click', () => this.reset());
        
        // Mouse wheel zoom
        modal.addEventListener('wheel', (e) => {
            e.preventDefault();
            if (e.deltaY < 0) {
                this.zoomIn();
            } else {
                this.zoomOut();
            }
        });
        
        // Drag to pan
        modalImage.addEventListener('mousedown', (e) => this.startDrag(e));
        document.addEventListener('mousemove', (e) => this.drag(e));
        document.addEventListener('mouseup', () => this.endDrag());
        
        // Touch events for mobile
        modalImage.addEventListener('touchstart', (e) => this.startDrag(e.touches[0]));
        document.addEventListener('touchmove', (e) => {
            if (this.isDragging) {
                e.preventDefault();
                this.drag(e.touches[0]);
            }
        });
        document.addEventListener('touchend', () => this.endDrag());
    }
    
    addKeyboardEvents() {
        document.addEventListener('keydown', (e) => {
            const modal = document.getElementById('image-viewer-modal');
            
            // Only handle keys when modal is open
            if (modal.classList.contains('hidden')) return;
            
            switch(e.key) {
                case 'Escape':
                    this.closeModal();
                    break;
                case '+':
                case '=':
                    this.zoomIn();
                    break;
                case '-':
                case '_':
                    this.zoomOut();
                    break;
                case 'ArrowLeft':
                    this.previousImage();
                    break;
                case 'ArrowRight':
                    this.nextImage();
                    break;
                case 'r':
                case 'R':
                    this.rotateRight();
                    break;
                case 'l':
                case 'L':
                    this.rotateLeft();
                    break;
            }
        });
    }
    
    addImageClickEvents() {
        if (!this.container) return;
        
        const imageElements = this.container.querySelectorAll('.product-image');
        imageElements.forEach((img, index) => {
            img.style.cursor = 'pointer';
            img.addEventListener('click', () => {
                this.currentIndex = index;
                this.openModal();
            });
        });
    }
    
    openModal() {
        const modal = document.getElementById('image-viewer-modal');
        const modalImage = document.getElementById('modal-image');
        const thumbnailsContainer = document.getElementById('thumbnails-container');
        
        // Set current image
        if (this.images.length > 0) {
            modalImage.src = this.images[this.currentIndex];
        }
        
        // Clear and recreate thumbnails
        thumbnailsContainer.innerHTML = '';
        this.images.forEach((img, index) => {
            const thumb = document.createElement('div');
            thumb.className = `w-16 h-16 bg-cover bg-center rounded cursor-pointer transition-all ${index === this.currentIndex ? 'ring-2 ring-white' : 'opacity-70 hover:opacity-100'}`;
            thumb.style.backgroundImage = `url("${img}")`;
            thumb.addEventListener('click', () => {
                this.currentIndex = index;
                modalImage.src = img;
                this.updateThumbnails();
            });
            thumbnailsContainer.appendChild(thumb);
        });
        
        // Show modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Reset view
        this.reset();
    }
    
    closeModal() {
        const modal = document.getElementById('image-viewer-modal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
    
    updateThumbnails() {
        const thumbnails = document.querySelectorAll('#thumbnails-container > div');
        thumbnails.forEach((thumb, index) => {
            if (index === this.currentIndex) {
                thumb.classList.add('ring-2', 'ring-white');
                thumb.classList.remove('opacity-70');
            } else {
                thumb.classList.remove('ring-2', 'ring-white');
                thumb.classList.add('opacity-70');
            }
        });
    }
    
    zoomIn() {
        this.zoom = Math.min(this.zoom * 1.2, 5);
        this.updateTransform();
    }
    
    zoomOut() {
        this.zoom = Math.max(this.zoom / 1.2, 0.5);
        this.updateTransform();
    }
    
    rotateLeft() {
        this.rotation -= 90;
        this.updateTransform();
    }
    
    rotateRight() {
        this.rotation += 90;
        this.updateTransform();
    }
    
    reset() {
        this.zoom = 1;
        this.rotation = 0;
        this.translateX = 0;
        this.translateY = 0;
        this.updateTransform();
    }
    
    previousImage() {
        if (this.images.length <= 1) return;
        
        this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
        document.getElementById('modal-image').src = this.images[this.currentIndex];
        this.updateThumbnails();
        this.reset();
    }
    
    nextImage() {
        if (this.images.length <= 1) return;
        
        this.currentIndex = (this.currentIndex + 1) % this.images.length;
        document.getElementById('modal-image').src = this.images[this.currentIndex];
        this.updateThumbnails();
        this.reset();
    }
    
    startDrag(e) {
        this.isDragging = true;
        this.startX = e.clientX - this.translateX;
        this.startY = e.clientY - this.translateY;
        
        document.getElementById('modal-image').style.cursor = 'grabbing';
    }
    
    drag(e) {
        if (!this.isDragging) return;
        
        this.translateX = e.clientX - this.startX;
        this.translateY = e.clientY - this.startY;
        this.updateTransform();
    }
    
    endDrag() {
        this.isDragging = false;
        document.getElementById('modal-image').style.cursor = 'move';
    }
    
    updateTransform() {
        const modalImage = document.getElementById('modal-image');
        modalImage.style.transform = `scale(${this.zoom}) rotate(${this.rotation}deg) translate(${this.translateX}px, ${this.translateY}px)`;
        
        // Update zoom level display
        document.getElementById('zoom-level').textContent = `${Math.round(this.zoom * 100)}%`;
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Auto-initialize image viewer if there's a product gallery
    const productGallery = document.querySelector('.product-gallery');
    if (productGallery) {
        new ImageViewer(productGallery);
    }
});

// Export for manual initialization
window.ImageViewer = ImageViewer;
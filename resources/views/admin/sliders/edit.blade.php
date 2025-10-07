<x-admin-layout title="Edit Slider - Admin">
    <main class="flex-1 container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mb-2">
                    <a href="{{ route('admin.sliders.index') }}" class="hover:text-primary">Sliders</a>
                    <span>/</span>
                    <span>Edit: {{ $slider->title }}</span>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Edit Slider</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Update the slider content and settings</p>
            </div>
            <a href="{{ route('admin.sliders.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600">
                <span class="material-symbols-outlined">arrow_back</span>
                Back to Sliders
            </a>
        </div>

        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div class="bg-white dark:bg-background-dark shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Slider Information</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Basic information about your slider.</p>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $slider->title) }}" required
                                   class="w-full px-4 py-2 rounded-lg bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50">
                        </div>

                        <div>
                            <label for="subtitle" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subtitle</label>
                            <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $slider->subtitle) }}"
                                   class="w-full px-4 py-2 rounded-lg bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50">
                        </div>

                        <div>
                            <label for="image_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Slider Image</label>
                            @if($slider->image_url)
                                <div class="mb-4">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Current image:</p>
                                    <img src="{{ asset('storage/' . $slider->image_url) }}" alt="{{ $slider->title }}" class="h-32 w-48 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                                </div>
                            @endif
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg bg-white dark:bg-background-dark">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                        <label for="image_url" class="relative cursor-pointer bg-white dark:bg-background-dark rounded-md font-medium text-primary hover:text-primary/90 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary">
                                            <span>Upload a file</span>
                                            <input id="image_url" name="image_url" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF up to 2MB</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="button_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Button Text</label>
                                <input type="text" name="button_text" id="button_text" value="{{ old('button_text', $slider->button_text) }}"
                                       class="w-full px-4 py-2 rounded-lg bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50">
                            </div>

                            <div>
                                <label for="button_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Button Link</label>
                                <input type="url" name="button_link" id="button_link" value="{{ old('button_link', $slider->button_link) }}"
                                       class="w-full px-4 py-2 rounded-lg bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50">
                            </div>

                            <div>
                                <label for="order_no" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Order</label>
                                <input type="number" name="order_no" id="order_no" value="{{ old('order_no', $slider->order_no) }}" min="0"
                                       class="w-full px-4 py-2 rounded-lg bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50">
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                                <select name="status" id="status" required
                                        class="w-full px-4 py-2 rounded-lg bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50">
                                    <option value="active" {{ old('status', $slider->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $slider->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <div class="flex items-center gap-4">
                        <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this slider? This action cannot be undone.')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-6 py-2 bg-red-500 text-white rounded-lg font-medium hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Delete Slider
                            </button>
                        </form>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('admin.sliders.show', $slider) }}" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg font-medium hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Update Slider
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <!-- File Preview Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listener for file input
            document.getElementById('image_url').addEventListener('change', function(event) {
                console.log('File selected:', event);
                const file = event.target.files[0];
                
                if (file) {
                    console.log('File details:', {
                        name: file.name,
                        size: file.size,
                        type: file.type,
                        lastModified: file.lastModified
                    });
                    
                    // Display file preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        console.log('File loaded successfully');
                        // Create preview image if needed
                        const previewContainer = document.querySelector('.space-y-1.text-center');
                        const existingPreview = previewContainer.querySelector('img');
                        
                        if (existingPreview) {
                            existingPreview.src = e.target.result;
                        } else {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'mx-auto h-32 w-32 object-cover rounded-lg mt-4';
                            previewContainer.appendChild(img);
                        }
                    };
                    reader.onerror = function(e) {
                        console.error('Error reading file:', e);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</x-admin-layout>
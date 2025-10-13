<x-admin-layout title="Create Page - Admin">
    <main class="flex-1 container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Create New Page</h2>
            <a href="{{ route('admin.pages.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600">
                <span class="material-symbols-outlined">arrow_back</span>
                Back to Pages
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

        <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data" id="page-form" onsubmit="return handleFormSubmit(event)">
            @csrf
            <div class="space-y-6">
                <div class="bg-white dark:bg-background-dark shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Page Information</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Basic information about your page.</p>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                   class="w-full px-4 py-2 rounded-lg bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50">
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Slug</label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
                                   class="w-full px-4 py-2 rounded-lg bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50">
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">URL-friendly version of the title. Will be auto-generated from title if left empty.</p>
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
                            <textarea name="content" id="content" rows="10"
                                      class="w-full px-4 py-2 rounded-lg bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50">{{ old('content') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                                <select name="status" id="status" required
                                        class="w-full px-4 py-2 rounded-lg bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="featured_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Featured Image</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg bg-white dark:bg-background-dark">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                        <label for="featured_image" class="relative cursor-pointer bg-white dark:bg-background-dark rounded-md font-medium text-primary hover:text-primary/90 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary">
                                            <span>Upload a file</span>
                                            <input id="featured_image" name="featured_image" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF up to 2MB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.pages.index') }}" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg font-medium hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Create Page
                    </button>
                </div>
            </div>
        </form>
    </main>

    <!-- CKEditor Script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/full/ckeditor.js"></script>
    <script>
        // Global function for form submission
        function handleFormSubmit(event) {
            console.log('Form submitted');
            
            // Sync CKEditor content to textarea
            if (window.editor) {
                const editorData = window.editor.getData();
                document.getElementById('content').value = editorData;
                console.log('CKEditor content synced:', editorData);
            }
            
            const formData = new FormData(event.target);
            console.log('Form data:');
            for (let pair of formData.entries()) {
                console.log(pair[0] + ':', pair[1]);
            }
            
            // Check if content is empty
            const content = document.getElementById('content').value;
            if (!content || content.trim() === '' || content.trim() === '<p>&nbsp;</p>' || content.trim() === '<p></p>') {
                event.preventDefault();
                alert('Content is required. Please add content to your page.');
                if (window.editor) {
                    window.editor.editing.view.focus();
                }
                return false;
            }
            
            return true;
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded and DOM ready');
            
            ClassicEditor
                .create(document.querySelector('#content'), {
                    // Ensure proper data handling
                    initialData: document.querySelector('#content').value || '',
                    // Configure toolbar with source code button
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'link', '|',
                            'bulletedList', 'numberedList', '|',
                            'outdent', 'indent', '|',
                            'imageUpload', 'blockQuote', 'insertTable', '|',
                            'undo', 'redo', '|',
                            'sourceEditing'
                        ]
                    }
                })
                .then(editor => {
                    window.editor = editor;
                    
                    // Update the textarea when editor data changes
                    editor.model.document.on('change:data', () => {
                        const data = editor.getData();
                        document.querySelector('#content').value = data;
                    });
                })
                .catch(error => {
                    console.error('CKEditor initialization error:', error);
                });

            // Auto-generate slug from title
            document.getElementById('title').addEventListener('input', function() {
                const title = this.value;
                const slug = title.toLowerCase()
                    .replace(/[^\w\s-]/g, '') // Remove special characters
                    .replace(/\s+/g, '-') // Replace spaces with hyphens
                    .replace(/-+/g, '-'); // Replace multiple hyphens with single hyphen
                
                document.getElementById('slug').value = slug;
            });
            
            // Add event listener for file input
            document.getElementById('featured_image').addEventListener('change', function(event) {
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
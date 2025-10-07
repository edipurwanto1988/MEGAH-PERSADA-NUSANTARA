<x-admin-layout title="Create Post - Admin">
    <main class="flex-1 container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Create New Post</h2>
            <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600">
                <span class="material-symbols-outlined">arrow_back</span>
                Back to Posts
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

        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" id="post-form" onsubmit="return handleFormSubmit(event)">
            @csrf
            <div class="space-y-6">
                <div class="bg-white dark:bg-background-dark shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Post Information</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Basic information about your post.</p>
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
                            <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Excerpt</label>
                            <textarea name="excerpt" id="excerpt" rows="3"
                                      class="w-full px-4 py-2 rounded-lg bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50">{{ old('excerpt') }}</textarea>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Brief description of your post (optional).</p>
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
                            <textarea name="content" id="content" rows="10"
                                      class="w-full px-4 py-2 rounded-lg bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50">{{ old('content') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                                <div class="flex gap-2">
                                    <select name="category_id" id="category_id" required
                                            class="flex-1 px-4 py-2 rounded-lg bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50">
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name ?: $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" id="add-category-btn" class="px-3 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500" title="Add New Category">
                                        <span class="material-symbols-outlined">add</span>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                                <select name="status" id="status" required
                                        class="w-full px-4 py-2 rounded-lg bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50">
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
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
                    <a href="{{ route('admin.posts.index') }}" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg font-medium hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Create Post
                    </button>
                </div>
            </div>
        </form>
    </main>

    <!-- Add Category Modal - Moved outside main form -->
    <div id="add-category-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-background-dark">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Add New Category</h3>
                    <button id="close-category-modal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <form id="add-category-form" onsubmit="return handleCategorySubmit(event)">
                    @csrf
                    <div class="mb-4">
                        <label for="new-category-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category Name</label>
                        <input type="text" id="new-category-name" name="name" required
                               class="w-full px-4 py-2 rounded-lg bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50">
                    </div>
                    <div class="mb-4">
                        <label for="new-category-description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                        <textarea id="new-category-description" name="description" rows="3"
                                  class="w-full px-4 py-2 rounded-lg bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50"></textarea>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" id="cancel-add-category" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">
                            Add Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CKEditor Script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
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
                alert('Content is required. Please add content to your post.');
                if (window.editor) {
                    window.editor.editing.view.focus();
                }
                return false;
            }
            
            return true;
        }
        
        // Global function for category form submission
        function handleCategorySubmit(event) {
            event.preventDefault();
            
            // Validate form
            const categoryName = document.getElementById('new-category-name').value.trim();
            if (!categoryName) {
                // Focus on the input field
                document.getElementById('new-category-name').focus();
                return false;
            }
            
            const formData = new FormData(event.target);
            
            fetch('{{ route('admin.post-categories.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add new option to select
                    const newOption = document.createElement('option');
                    newOption.value = data.category.id;
                    newOption.textContent = data.category.name;
                    newOption.selected = true;
                    
                    // Clear any existing selection
                    const categorySelect = document.getElementById('category_id');
                    for (let i = 0; i < categorySelect.options.length; i++) {
                        categorySelect.options[i].selected = false;
                    }
                    
                    // Add the new option and select it
                    categorySelect.appendChild(newOption);
                    
                    // Show success message
                    const successDiv = document.createElement('div');
                    successDiv.className = 'mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded';
                    successDiv.textContent = 'Category added successfully!';
                    
                    const postForm = document.querySelector('form');
                    postForm.parentNode.insertBefore(successDiv, postForm);
                    
                    // Remove success message after 3 seconds
                    setTimeout(() => {
                        successDiv.remove();
                    }, 3000);
                    
                    // Close modal
                    closeModal();
                    
                    // Focus on the next field after category
                    document.getElementById('status').focus();
                } else {
                    // Show error message
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded';
                    errorDiv.textContent = 'Error adding category. Please try again.';
                    
                    const postForm = document.querySelector('form');
                    postForm.parentNode.insertBefore(errorDiv, postForm);
                    
                    // Remove error message after 3 seconds
                    setTimeout(() => {
                        errorDiv.remove();
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded';
                errorDiv.textContent = 'Error adding category. Please try again.';
                
                const postForm = document.querySelector('form');
                postForm.parentNode.insertBefore(errorDiv, postForm);
                
                // Remove error message after 3 seconds
                setTimeout(() => {
                    errorDiv.remove();
                }, 3000);
            });
            
            return false;
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded and DOM ready');
            
            ClassicEditor
                .create(document.querySelector('#content'), {
                    // Ensure proper data handling
                    initialData: document.querySelector('#content').value || ''
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

            // Category Modal Handling
            const addCategoryBtn = document.getElementById('add-category-btn');
            const addCategoryModal = document.getElementById('add-category-modal');
            const closeCategoryModal = document.getElementById('close-category-modal');
            const cancelAddCategory = document.getElementById('cancel-add-category');
            const addCategoryForm = document.getElementById('add-category-form');
            const categorySelect = document.getElementById('category_id');

            // Open modal
            addCategoryBtn.addEventListener('click', function(e) {
                e.preventDefault();
                addCategoryModal.classList.remove('hidden');
            });

            // Close modal
            function closeModal() {
                addCategoryModal.classList.add('hidden');
                addCategoryForm.reset();
            }

            closeCategoryModal.addEventListener('click', closeModal);
            cancelAddCategory.addEventListener('click', closeModal);

            // Close modal when clicking outside
            addCategoryModal.addEventListener('click', function(e) {
                if (e.target === addCategoryModal) {
                    closeModal();
                }
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
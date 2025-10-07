<x-admin-layout title="Edit Product - Admin">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Edit Product</h1>
                <p class="mt-1 text-sm text-gray-600">Update product information, specifications and images</p>
            </div>

            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <!-- Product Information -->
                    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6">
                                <label for="product_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                                <input type="text" name="product_name" id="product_name" value="{{ old('product_name', $product->product_name) }}" required
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="4" required
                                          class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $product->description) }}</textarea>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="final_price" class="block text-sm font-medium text-gray-700">Final Price (Optional)</label>
                                <input type="number" name="final_price" id="final_price" value="{{ old('final_price', $product->final_price) }}" step="0.01" min="0"
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <p class="mt-2 text-sm text-gray-500">Leave empty if same as price</p>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="category_id" id="category_id" required
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" required
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="col-span-6">
                                <label for="external_link" class="block text-sm font-medium text-gray-700">External Link</label>
                                <input type="url" name="external_link" id="external_link" value="{{ old('external_link', $product->external_link) }}"
                                       placeholder="https://example.com"
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <p class="mt-2 text-sm text-gray-500">Optional external link for this product</p>
                            </div>

                            <div class="col-span-6">
                                <label for="seo_description" class="block text-sm font-medium text-gray-700">SEO Description</label>
                                <textarea name="seo_description" id="seo_description" rows="3"
                                          placeholder="Brief description for SEO (recommended: 150-160 characters)"
                                          class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('seo_description', $product->seo_description) }}</textarea>
                                <p class="mt-2 text-sm text-gray-500">Meta description for search engines</p>
                            </div>

                        </div>
                    </div>

                    <!-- Existing Images -->
                    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Existing Images</h3>
                                <p class="mt-1 text-sm text-gray-500">Current product images.</p>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="grid grid-cols-3 gap-4">
                                    @foreach($product->images as $image)
                                        <div class="relative group">
                                            <img src="{{ Storage::url($image->image_url) }}" alt="Product Image"
                                                 class="w-full h-32 object-cover rounded-lg border border-gray-300">
                                            <div class="absolute bottom-2 left-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                                                Thumbnail:
                                                @if($image->thumbnail_url)
                                                    <img src="{{ Storage::url($image->thumbnail_url) }}" alt="Thumbnail" class="w-5 h-5 inline">
                                                @else
                                                    <span class="text-red-500">Not Generated</span>
                                                @endif
                                            </div>
                                            <button type="button" onclick="deleteImage({{ $image->id }})"
                                                    class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- New Images -->
                    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">New Images</h3>
                                <p class="mt-1 text-sm text-gray-500">Add new product images with preview.</p>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div id="new-images-container" class="space-y-3">
                                    <!-- Images will be added here dynamically -->
                                </div>
                                <button type="button" id="add-new-image" class="mt-3 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    + Add New Image
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Existing Specifications -->
                    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Existing Specifications</h3>
                                <p class="mt-1 text-sm text-gray-500">Current product specifications.</p>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="space-y-3">
                                    <!-- Debug: Show specifications count -->
                                    <div class="text-xs text-gray-500">
                                        Specifications count: {{ $product->specifications ? $product->specifications->count() : 'null' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        Product ID: {{ $product->id }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        Specifications relationship: {{ $product->specifications ? 'exists' : 'null' }}
                                    </div>
                                    @if($product->specifications)
                                        <div class="text-xs text-gray-500">
                                            Specifications as JSON: {{ json_encode($product->specifications) }}
                                        </div>
                                    @endif
                                    
                                    @if($product->specifications && $product->specifications->count() > 0)
                                        <div class="text-xs text-green-500">
                    Showing {{ $product->specifications->count() }} specifications
                </div>
                                        @foreach($product->specifications as $spec)
                                            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-md">
                                                <div class="flex-1">
                                                    <div class="font-medium text-gray-900">{{ $spec->spec_name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $spec->pivot->spec_value }}</div>
                                                </div>
                                                <button type="button" onclick="deleteSpecification({{ $spec->id }})"
                                                        class="ml-3 bg-red-600 hover:bg-red-700 text-white p-2 rounded">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-sm text-gray-500">No specifications added yet.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- New Specifications -->
                    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">New Specifications</h3>
                                <p class="mt-1 text-sm text-gray-500">Add new product specifications with their values.</p>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div id="specifications-container" class="space-y-3">
                                    <!-- New specifications will be added here -->
                                </div>
                                <button type="button" id="add-specification" class="mt-3 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    + Add Specification
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.products.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Product
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const specificationsContainer = document.getElementById('specifications-container');
            const addSpecificationBtn = document.getElementById('add-specification');
            const newImagesContainer = document.getElementById('new-images-container');
            const addNewImageBtn = document.getElementById('add-new-image');
            let specificationIndex = 0;
            let newImageIndex = 0;

            const specifications = @json($specifications);
            const existingSpecifications = @json($product->specifications);
            
            // Debug: Log existing specifications
            console.log('Existing specifications:', existingSpecifications);

            function addSpecification(specData = null) {
                const div = document.createElement('div');
                div.className = 'flex gap-3 items-center specification-row';
                
                div.innerHTML = `
                    <select name="specifications[${specificationIndex}][specification_id]" required
                            class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select a specification</option>
                        ${specifications.map(spec =>
                            `<option value="${spec.id}" ${specData && specData.specification_id == spec.id ? 'selected' : ''}>${spec.spec_name}</option>`
                        ).join('')}
                    </select>
                    <input type="text" name="specifications[${specificationIndex}][spec_value]"
                           value="${specData ? specData.spec_value : ''}"
                           placeholder="Specification value" required
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <button type="button" onclick="saveSpecification(this, ${specificationIndex})"
                            class="bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded">
                        <i class="fas fa-save"></i>
                    </button>
                    <button type="button" onclick="removeSpecification(this)"
                            class="bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
                
                specificationsContainer.appendChild(div);
                specificationIndex++;
            }

            window.removeSpecification = function(button) {
                button.parentElement.remove();
            };

            window.saveSpecification = function(button, index) {
                const row = button.parentElement;
                const specificationId = row.querySelector('select').value;
                const specValue = row.querySelector('input').value;
                
                if (!specificationId || !specValue) {
                    alert('Please select a specification and enter a value');
                    return;
                }
                
                // Show loading state
                const originalHtml = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                button.disabled = true;
                
                // Send AJAX request to save specification
                fetch(`{{ route('admin.products.saveSpecification', $product) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        specification_id: specificationId,
                        spec_value: specValue
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        const successDiv = document.createElement('div');
                        successDiv.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-2';
                        successDiv.textContent = data.message;
                        row.appendChild(successDiv);
                        
                        // Remove success message after 3 seconds
                        setTimeout(() => {
                            successDiv.remove();
                        }, 3000);
                    } else {
                        // Show error message
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-2';
                        errorDiv.textContent = data.message || 'Error saving specification';
                        row.appendChild(errorDiv);
                        
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
                    errorDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-2';
                    errorDiv.textContent = 'Error saving specification';
                    row.appendChild(errorDiv);
                    
                    // Remove error message after 3 seconds
                    setTimeout(() => {
                        errorDiv.remove();
                    }, 3000);
                })
                .finally(() => {
                    // Restore button state
                    button.innerHTML = originalHtml;
                    button.disabled = false;
                });
            };

            window.deleteSpecification = function(specificationId) {
                if (!confirm('Are you sure you want to delete this specification?')) {
                    return;
                }
                
                // Send AJAX request to delete specification
                fetch(`/admin/products/{{ $product->id }}/specifications/${specificationId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload the page to show updated specifications
                        window.location.reload();
                    } else {
                        // Show error message
                        alert(data.message || 'Error deleting specification');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting specification');
                });
            };

            window.deleteImage = function(imageId) {
                if (!confirm('Are you sure you want to delete this image?')) {
                    return;
                }
                
                // Send AJAX request to delete image
                fetch(`/admin/products/{{ $product->id }}/images/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the image element from the DOM
                        const imageElement = document.querySelector(`button[onclick="deleteImage(${imageId})"]`).parentElement;
                        imageElement.remove();
                        
                        // Show success message
                        const successDiv = document.createElement('div');
                        successDiv.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-2';
                        successDiv.textContent = data.message;
                        document.querySelector('.grid.grid-cols-3.gap-4').appendChild(successDiv);
                        
                        // Remove success message after 3 seconds
                        setTimeout(() => {
                            successDiv.remove();
                        }, 3000);
                    } else {
                        // Show error message
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-2';
                        errorDiv.textContent = data.message || 'Error deleting image';
                        document.querySelector('.grid.grid-cols-3.gap-4').appendChild(errorDiv);
                        
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
                    errorDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-2';
                    errorDiv.textContent = 'Error deleting image';
                    document.querySelector('.grid.grid-cols-3.gap-4').appendChild(errorDiv);
                    
                    // Remove error message after 3 seconds
                    setTimeout(() => {
                        errorDiv.remove();
                    }, 3000);
                });
            };

            function addNewImage() {
                const div = document.createElement('div');
                div.className = 'flex gap-3 items-center image-row';
                
                div.innerHTML = `
                    <input type="file" name="new_images[${newImageIndex}]" accept="image/*"
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                           onchange="previewNewImage(this)">
                    <div class="w-20 h-20 border border-gray-300 rounded-md overflow-hidden image-preview">
                        <img src="" alt="Preview" class="w-full h-full object-cover hidden">
                    </div>
                    <button type="button" onclick="removeNewImage(this)"
                            class="bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
                
                newImagesContainer.appendChild(div);
                newImageIndex++;
            }

            window.removeNewImage = function(button) {
                button.parentElement.remove();
            };

            window.previewNewImage = function(input) {
                const preview = input.parentElement.querySelector('.image-preview img');
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            };

            addSpecificationBtn.addEventListener('click', function() {
                addSpecification();
            });

            addNewImageBtn.addEventListener('click', function() {
                addNewImage();
            });

            // Load existing specifications
            if (existingSpecifications && existingSpecifications.length > 0) {
                existingSpecifications.forEach(spec => {
                    addSpecification({
                        specification_id: spec.id,
                        spec_value: spec.pivot.spec_value
                    });
                });
            } else {
                // Add one empty specification if none exist
                addSpecification();
            }
        });
    </script>
</x-admin-layout>
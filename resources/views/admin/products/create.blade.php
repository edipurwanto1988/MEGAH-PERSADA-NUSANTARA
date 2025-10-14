<x-admin-layout title="Create Product - Admin">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Create New Product</h1>
                <p class="mt-1 text-sm text-gray-600">Create a new product with specifications and images</p>
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

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <!-- Product Information -->
                    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6">
                                <label for="product_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                                <input type="text" name="product_name" id="product_name" value="{{ old('product_name') }}" required
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="4" required
                                          class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description') }}</textarea>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="final_price" class="block text-sm font-medium text-gray-700">Final Price (Optional)</label>
                                <input type="number" name="final_price" id="final_price" value="{{ old('final_price') }}" step="0.01" min="0"
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <p class="mt-2 text-sm text-gray-500">Leave empty if same as price</p>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="category_id" id="category_id" required
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" required
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="col-span-6">
                                <label for="external_link" class="block text-sm font-medium text-gray-700">External Link</label>
                                <input type="url" name="external_link" id="external_link" value="{{ old('external_link', '') }}"
                                       placeholder="https://example.com"
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <p class="mt-2 text-sm text-gray-500">Optional external link for this product</p>
                            </div>

                            <div class="col-span-6">
                                <label for="seo_description" class="block text-sm font-medium text-gray-700">SEO Description</label>
                                <textarea name="seo_description" id="seo_description" rows="3"
                                          placeholder="Brief description for SEO (recommended: 150-160 characters)"
                                          class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('seo_description') }}</textarea>
                                <p class="mt-2 text-sm text-gray-500">Meta description for search engines</p>
                            </div>

                        </div>
                    </div>

                    <!-- Images -->
                    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Product Images</h3>
                                <p class="mt-1 text-sm text-gray-500">Add product images with preview.</p>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div id="images-container" class="space-y-3">
                                    <!-- Images will be added here dynamically -->
                                </div>
                                <button type="button" id="add-image" class="mt-3 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    + Add Image
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Specifications -->
                    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Specifications</h3>
                                <p class="mt-1 text-sm text-gray-500">Add product specifications with their values.</p>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div id="specifications-container" class="space-y-3">
                                    <!-- Specifications will be added here dynamically -->
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
                            Create Product
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
            const imagesContainer = document.getElementById('images-container');
            const addImageBtn = document.getElementById('add-image');
            let specificationIndex = 0;
            let imageIndex = 0;

            const specifications = @json($specifications);

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
                    <button type="button" onclick="removeSpecification(this)"
                            class="bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
                
                specificationsContainer.appendChild(div);
                specificationIndex++;
            }

            function addImage() {
                const div = document.createElement('div');
                div.className = 'flex gap-3 items-center image-row';
                
                div.innerHTML = `
                    <input type="file" name="images[${imageIndex}]" accept="image/*"
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                           onchange="previewImage(this)">
                    <div class="w-20 h-20 border border-gray-300 rounded-md overflow-hidden image-preview">
                        <img src="" alt="Preview" class="w-full h-full object-cover hidden">
                    </div>
                    <button type="button" onclick="removeImage(this)"
                            class="bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
                
                imagesContainer.appendChild(div);
                imageIndex++;
            }

            window.removeSpecification = function(button) {
                button.parentElement.remove();
            };

            window.removeImage = function(button) {
                button.parentElement.remove();
            };

            window.previewImage = function(input) {
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

            addImageBtn.addEventListener('click', function() {
                addImage();
            });

            // Add one specification by default
            addSpecification();
            
            // Add one image by default
            addImage();
        });
    </script>
</x-admin-layout>
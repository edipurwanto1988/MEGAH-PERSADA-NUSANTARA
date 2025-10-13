<x-admin-layout title="Edit Post Category - Admin">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Edit Post Category</h1>
                <p class="mt-1 text-sm text-gray-600">Update your blog post category</p>
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

            <form action="{{ route('admin.post-categories.update', $postCategory) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Category Information</h3>
                                <p class="mt-1 text-sm text-gray-500">Basic information about your category.</p>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                                        <input type="text" name="name" id="name" value="{{ old('name', $postCategory->name) }}" required
                                               class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6">
                                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea name="description" id="description" rows="3"
                                                  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $postCategory->description) }}</textarea>
                                        <p class="mt-2 text-sm text-gray-500">Brief description of your category (optional).</p>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="parent_id" class="block text-sm font-medium text-gray-700">Parent Category</label>
                                        <select name="parent_id" id="parent_id"
                                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="">None (Root Category)</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('parent_id', $postCategory->parent_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="mt-2 text-sm text-gray-500">Select a parent category if this is a subcategory.</p>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                        <select name="status" id="status"
                                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="1" {{ old('status', $postCategory->status) == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ old('status', $postCategory->status) == '0' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        <p class="mt-2 text-sm text-gray-500">Only active categories will be shown on the website.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">SEO Information</h3>
                                <p class="mt-1 text-sm text-gray-500">Optimize your category for search engines.</p>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6">
                                        <label for="seo_title" class="block text-sm font-medium text-gray-700">SEO Title</label>
                                        <input type="text" name="seo_title" id="seo_title" value="{{ old('seo_title', $postCategory->seo_title) }}"
                                               class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <p class="mt-2 text-sm text-gray-500">Custom title for search engines (optional).</p>
                                    </div>

                                    <div class="col-span-6">
                                        <label for="seo_description" class="block text-sm font-medium text-gray-700">SEO Description</label>
                                        <textarea name="seo_description" id="seo_description" rows="3"
                                                  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('seo_description', $postCategory->seo_description) }}</textarea>
                                        <p class="mt-2 text-sm text-gray-500">Meta description for search engines (optional).</p>
                                    </div>

                                    <div class="col-span-6">
                                        <label for="seo_keywords" class="block text-sm font-medium text-gray-700">SEO Keywords</label>
                                        <input type="text" name="seo_keywords" id="seo_keywords" value="{{ old('seo_keywords', $postCategory->seo_keywords) }}"
                                               class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <p class="mt-2 text-sm text-gray-500">Comma-separated keywords for SEO (optional).</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Media</h3>
                                <p class="mt-1 text-sm text-gray-500">Add images and tags to your category.</p>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6">
                                        <label for="featured_image" class="block text-sm font-medium text-gray-700">Featured Image</label>
                                        @if($postCategory->featured_image)
                                            <div class="mt-2 mb-4">
                                                <img src="{{ Storage::url($postCategory->featured_image) }}" alt="{{ $postCategory->name }}" class="h-32 w-32 object-cover rounded">
                                                <p class="mt-1 text-sm text-gray-500">Current featured image</p>
                                            </div>
                                        @endif
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="featured_image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                        <span>Upload a file</span>
                                                        <input id="featured_image" name="featured_image" type="file" class="sr-only" accept="image/*">
                                                    </label>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-span-6">
                                        <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                                        <input type="text" name="tags" id="tags" value="{{ old('tags', $postCategory->tags) }}"
                                               class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <p class="mt-2 text-sm text-gray-500">Comma-separated tags for this category (optional).</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.post-categories.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Category
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
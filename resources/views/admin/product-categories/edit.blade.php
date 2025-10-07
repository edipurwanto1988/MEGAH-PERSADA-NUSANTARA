<x-admin-layout title="Edit Product Category - Admin">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Edit Product Category</h1>
                <p class="mt-1 text-sm text-gray-600">Update your product category</p>
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

            <form action="{{ route('admin.product-categories.update', $productCategory) }}" method="POST">
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
                                        <label for="category_name" class="block text-sm font-medium text-gray-700">Category Name</label>
                                        <input type="text" name="category_name" id="category_name" value="{{ old('category_name', $productCategory->category_name) }}" required
                                               class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6">
                                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea name="description" id="description" rows="3"
                                                  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $productCategory->description) }}</textarea>
                                        <p class="mt-2 text-sm text-gray-500">Brief description of your category (optional).</p>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="parent_id" class="block text-sm font-medium text-gray-700">Parent Category</label>
                                        <select name="parent_id" id="parent_id"
                                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="">None (Root Category)</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('parent_id', $productCategory->parent_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="mt-2 text-sm text-gray-500">Select a parent category if this is a subcategory.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.product-categories.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
<x-admin-layout title="{{ $productCategory->category_name }} - Admin">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">{{ $productCategory->category_name }}</h1>
                        <div class="mt-2 flex items-center space-x-4">
                            @if($productCategory->parent)
                                <span class="text-sm text-gray-500">
                                    Parent: {{ $productCategory->parent->category_name }}
                                </span>
                            @endif
                            <span class="text-sm text-gray-500">
                                Created: {{ $productCategory->created_at->format('M d, Y H:i') }}
                            </span>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.product-categories.edit', $productCategory) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                        <form action="{{ route('admin.product-categories.destroy', $productCategory) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Category Details</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Full category information and statistics.</p>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Slug</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $productCategory->slug }}</dd>
                        </div>
                        
                        @if($productCategory->description)
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $productCategory->description }}</dd>
                        </div>
                        @endif

                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Products Count</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $productCategory->products->count() }} products</dd>
                        </div>

                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Subcategories</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($productCategory->children->count() > 0)
                                    <ul class="list-disc list-inside">
                                        @foreach($productCategory->children as $child)
                                            <li>
                                                <a href="{{ route('admin.product-categories.show', $child) }}" class="text-blue-600 hover:text-blue-900">
                                                    {{ $child->category_name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-gray-500">No subcategories</span>
                                @endif
                            </dd>
                        </div>

                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Recent Products</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($productCategory->products->count() > 0)
                                    <ul class="list-disc list-inside">
                                        @foreach($productCategory->products()->take(5)->get() as $product)
                                            <li>
                                                <a href="{{ route('admin.products.show', $product) }}" class="text-blue-600 hover:text-blue-900">
                                                    {{ $product->name }}
                                                </a>
                                                <span class="text-gray-500 text-xs">({{ $product->created_at->format('M d, Y') }})</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @if($productCategory->products->count() > 5)
                                        <p class="mt-2 text-sm text-gray-500">
                                            And {{ $productCategory->products->count() - 5 }} more products...
                                        </p>
                                    @endif
                                @else
                                    <span class="text-gray-500">No products in this category</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.product-categories.index') }}" class="text-blue-600 hover:text-blue-900">
                    ← Back to Categories
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>
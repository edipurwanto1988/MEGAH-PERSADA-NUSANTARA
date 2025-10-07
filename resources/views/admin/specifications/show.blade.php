<x-admin-layout title="Specification Details - Admin">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-gray-900">Specification Details</h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.specifications.edit', $specification) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Specification
                        </a>
                        <a href="{{ route('admin.specifications.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $specification->spec_name }}</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Specification information and associated products.</p>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Specification Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $specification->spec_name }}</dd>
                        </div>
                        
                        @if($specification->description)
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $specification->description }}</dd>
                        </div>
                        @endif
                        
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $specification->created_at->format('M d, Y H:i') }}</dd>
                        </div>
                        
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $specification->updated_at->format('M d, Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Products using this specification -->
            <div class="mt-8">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Products using this specification ({{ $specification->products->count() }})</h2>
                
                @if($specification->products->count() > 0)
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <ul class="divide-y divide-gray-200">
                            @foreach($specification->products as $product)
                                <li class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-sm font-medium text-gray-900">
                                                <a href="{{ route('admin.products.show', $product) }}" class="hover:text-blue-600">
                                                    {{ $product->product_name }}
                                                </a>
                                            </h3>
                                            <div class="mt-1 flex items-center space-x-4">
                                                <span class="text-sm text-gray-500">
                                                    Specification Value: {{ $product->pivot->spec_value }}
                                                </span>
                                                <span class="text-sm text-gray-500">
                                                    Category: {{ $product->category->category_name ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-900">
                                                Edit Product
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-8 text-center text-gray-500">
                            No products are using this specification yet.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
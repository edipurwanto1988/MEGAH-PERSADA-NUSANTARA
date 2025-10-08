<x-admin-layout title="Product Details - Admin">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-gray-900">Product Details</h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-edit mr-2"></i>Edit Product
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-arrow-left mr-2"></i>Back to List
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $product->product_name }}</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Product information and specifications.</p>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Product Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->product_name }}</dd>
                        </div>
                        
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->description }}</dd>
                        </div>
                        
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Price</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                ${{ number_format($product->price, 2) }}
                                @if($product->final_price && $product->final_price != $product->price)
                                    <span class="ml-2 text-green-600 font-semibold">
                                        Final Price: ${{ number_format($product->final_price, 2) }}
                                    </span>
                                @endif
                            </dd>
                        </div>
                        
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Category</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->category->category_name ?? 'N/A' }}</dd>
                        </div>
                        
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 sm:mt-0 sm:col-span-2">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $product->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->status }}
                                </span>
                            </dd>
                        </div>
                        
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Images</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <div class="grid grid-cols-4 gap-4">
                                    @if($product->image)
                                        <div class="relative group">
                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->product_name }}"
                                                 class="w-full h-32 object-cover rounded-lg border border-gray-300">
                                            <div class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded">Main</div>
                                        </div>
                                    @endif
                                    @foreach($product->images as $image)
                                        <div class="relative group">
                                            <img src="{{ Storage::url($image->image_url) }}" alt="{{ $product->product_name }}"
                                                 class="w-full h-32 object-cover rounded-lg border border-gray-300">
                                        </div>
                                    @endforeach
                                </div>
                                @if(!$product->image && $product->images->count() == 0)
                                    <div class="h-32 w-32 bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-gray-500">No Images</span>
                                    </div>
                                @endif
                            </dd>
                        </div>
                        
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->created_at->format('M d, Y H:i') }}</dd>
                        </div>
                        
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->updated_at->format('M d, Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Specifications -->
            <div class="mt-8">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Specifications</h2>
                
                @if($product->specifications()->get()->count() > 0)
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <ul class="divide-y divide-gray-200">
                            @foreach($product->specifications()->get() as $specification)
                                <li class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-sm font-medium text-gray-900">
                                                {{ $specification->spec_name }}
                                            </h3>
                                            <div class="mt-1">
                                                <span class="text-sm text-gray-500">
                                                    Value: {{ $specification->pivot->spec_value }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.specifications.show', $specification) }}" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye mr-1"></i>View Specification
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
                            No specifications added to this product yet.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
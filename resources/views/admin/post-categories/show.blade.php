<x-admin-layout title="{{ $postCategory->name }} - Admin">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">{{ $postCategory->name }}</h1>
                        <div class="mt-2 flex items-center space-x-4">
                            @if($postCategory->parent)
                                <span class="text-sm text-gray-500">
                                    Parent: {{ $postCategory->parent->name }}
                                </span>
                            @endif
                            <span class="text-sm text-gray-500">
                                Created: {{ $postCategory->created_at->format('M d, Y H:i') }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $postCategory->status ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $postCategory->status ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.post-categories.edit', $postCategory) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                        <form action="{{ route('admin.post-categories.destroy', $postCategory) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')">
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
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $postCategory->slug }}</dd>
                        </div>
                        
                        @if($postCategory->description)
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $postCategory->description }}</dd>
                        </div>
                        @endif

                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Posts Count</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $postCategory->posts->count() }} posts</dd>
                        </div>

                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Subcategories</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($postCategory->children->count() > 0)
                                    <ul class="list-disc list-inside">
                                        @foreach($postCategory->children as $child)
                                            <li>
                                                <a href="{{ route('admin.post-categories.show', $child) }}" class="text-blue-600 hover:text-blue-900">
                                                    {{ $child->name }}
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
                            <dt class="text-sm font-medium text-gray-500">Recent Posts</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($postCategory->posts->count() > 0)
                                    <ul class="list-disc list-inside">
                                        @foreach($postCategory->posts()->take(5)->get() as $post)
                                            <li>
                                                <a href="{{ route('admin.posts.show', $post) }}" class="text-blue-600 hover:text-blue-900">
                                                    {{ $post->title }}
                                                </a>
                                                <span class="text-gray-500 text-xs">({{ $post->created_at->format('M d, Y') }})</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @if($postCategory->posts->count() > 5)
                                        <p class="mt-2 text-sm text-gray-500">
                                            And {{ $postCategory->posts->count() - 5 }} more posts...
                                        </p>
                                    @endif
                                @else
                                    <span class="text-gray-500">No posts in this category</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.post-categories.index') }}" class="text-blue-600 hover:text-blue-900">
                    ← Back to Categories
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>
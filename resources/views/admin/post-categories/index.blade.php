<x-admin-layout title="Post Categories - Admin">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-900">Post Categories</h1>
                <a href="{{ route('admin.post-categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create New Category
                </a>
            </div>

            @if(session('success'))
                <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">All Categories</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Manage your blog post categories here.</p>
                </div>
                <ul class="divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <li class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <h3 class="text-sm font-medium text-gray-900">
                                                <a href="{{ route('admin.post-categories.show', $category) }}" class="hover:text-blue-600">
                                                    {{ $category->name }}
                                                </a>
                                            </h3>
                                            <div class="mt-1 flex items-center space-x-4">
                                                @if($category->parent)
                                                    <span class="text-sm text-gray-500">
                                                        Parent: {{ $category->parent->name }}
                                                    </span>
                                                @endif
                                                @if($category->children->count() > 0)
                                                    <span class="text-sm text-gray-500">
                                                        Subcategories: {{ $category->children->count() }}
                                                    </span>
                                                @endif
                                                <span class="text-sm text-gray-500">
                                                    Posts: {{ $category->posts->count() }}
                                                </span>
                                                <span class="text-sm text-gray-500">
                                                    {{ $category->created_at->format('M d, Y') }}
                                                </span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->status ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ $category->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>
                                            @if($category->description)
                                                <p class="mt-2 text-sm text-gray-600">{{ Str::limit($category->description, 100) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.post-categories.show', $category) }}" class="text-blue-600 hover:text-blue-900">
                                        <span class="material-symbols-outlined align-middle text-sm">visibility</span>
                                        View
                                    </a>
                                    <a href="{{ route('admin.post-categories.edit', $category) }}" class="text-blue-600 hover:text-blue-900">
                                        <span class="material-symbols-outlined align-middle text-sm">edit</span>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.post-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <span class="material-symbols-outlined align-middle text-sm">delete</span>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="px-4 py-8 text-center text-gray-500">
                            No categories found. <a href="{{ route('admin.post-categories.create') }}" class="text-blue-600 hover:text-blue-900">Create your first category</a>.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-admin-layout>
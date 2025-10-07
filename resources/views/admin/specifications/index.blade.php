<x-admin-layout title="Specifications - Admin">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Specifications</h1>
                <a href="{{ route('admin.specifications.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-plus mr-2"></i>Create New Specification
                </a>
            </div>

            <!-- Search Form -->
            <div class="mb-6">
                <form method="GET" action="{{ route('admin.specifications.index') }}" class="flex gap-2">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="Search specifications by name or description..."
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Search
                    </button>
                    @if($search ?? null)
                        <a href="{{ route('admin.specifications.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded">
                            Clear
                        </a>
                    @endif
                </form>
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
                    <h3 class="text-lg leading-6 font-medium text-gray-900">All Specifications</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Manage your product specifications here.</p>
                </div>
                <ul class="divide-y divide-gray-200">
                    @forelse($specifications as $specification)
                        <li class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <h3 class="text-sm font-medium text-gray-900">
                                                <a href="{{ route('admin.specifications.show', $specification) }}" class="hover:text-blue-600">
                                                    {{ $specification->spec_name }}
                                                </a>
                                            </h3>
                                            <div class="mt-1 flex items-center space-x-4">
                                                <span class="text-sm text-gray-500">
                                                    Products: {{ $specification->products_count }}
                                                </span>
                                                <span class="text-sm text-gray-500">
                                                    {{ $specification->created_at->format('M d, Y') }}
                                                </span>
                                            </div>
                                            @if($specification->description)
                                                <p class="mt-2 text-sm text-gray-600">{{ Str::limit($specification->description, 100) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.specifications.edit', $specification) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <form action="{{ route('admin.specifications.destroy', $specification) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this specification?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash mr-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="px-4 py-8 text-center text-gray-500">
                            @if($search ?? null)
                                No specifications found for "{{ $search }}". <a href="{{ route('admin.specifications.create') }}" class="text-blue-600 hover:text-blue-900">Create a new specification</a> or <a href="{{ route('admin.specifications.index') }}" class="text-blue-600 hover:text-blue-900">clear search</a>.
                            @else
                                No specifications found. <a href="{{ route('admin.specifications.create') }}" class="text-blue-600 hover:text-blue-900">Create your first specification</a>.
                            @endif
                        </li>
                    @endforelse
                </ul>

                <!-- Pagination -->
                @if($specifications->hasPages())
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            {{ $specifications->links() }}
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">{{ $specifications->firstItem() }}</span>
                                    to
                                    <span class="font-medium">{{ $specifications->lastItem() }}</span>
                                    of
                                    <span class="font-medium">{{ $specifications->total() }}</span>
                                    results
                                </p>
                            </div>
                            <div>
                                {{ $specifications->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
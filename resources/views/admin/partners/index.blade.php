<x-admin-layout title="Partners - Admin">
    <main class="flex-1 container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Partners Management</h2>
            <a href="{{ route('admin.partners.create') }}" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90">
                <span class="material-symbols-outlined">add</span>
                Create New Partner
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-6">
            <form method="GET" action="{{ route('admin.partners.index') }}">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">search</span>
                    <input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 rounded-lg bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50" placeholder="Search partners..." type="text"/>
                </div>
                
                <div class="flex flex-wrap gap-4 mt-4">
                    <div class="relative">
                        <select name="status" class="appearance-none flex items-center gap-2 px-4 py-2 bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-primary/10 dark:hover:bg-primary/20 pr-8" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 pointer-events-none">expand_more</span>
                    </div>
                    
                    <div class="relative">
                        <select name="sort" class="appearance-none flex items-center gap-2 px-4 py-2 bg-white dark:bg-background-dark border border-gray-300 dark:border-gray-700 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-primary/10 dark:hover:bg-primary/20 pr-8" onchange="this.form.submit()">
                            <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                            <option value="order" {{ request('sort') == 'order' ? 'selected' : '' }}>Order</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 pointer-events-none">expand_more</span>
                    </div>
                    
                    @if(request()->hasAny(['status', 'sort', 'search']))
                        <a href="{{ route('admin.partners.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700">
                            <span class="material-symbols-outlined">clear</span>
                            Clear Filters
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-background-dark">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" scope="col">Logo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" scope="col">Partner Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" scope="col">Website</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" scope="col">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" scope="col">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" scope="col">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($partners as $partner)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($partner->logo)
                                    <img src="{{ Storage::url($partner->logo) }}" alt="{{ $partner->partner_name }}" class="h-12 w-12 object-cover rounded">
                                @else
                                    <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-gray-500 text-xs">No Logo</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $partner->partner_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                @if($partner->website)
                                    <a href="{{ $partner->website }}" target="_blank" class="text-primary hover:underline">
                                        {{ Str::limit($partner->website, 30) }}
                                    </a>
                                @else
                                    <span class="text-gray-400">No website</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $partner->order_no }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $partner->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' }}">
                                    {{ $partner->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $partner->created_at->format('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('admin.partners.show', $partner) }}" class="text-primary hover:underline">
                                        <span class="material-symbols-outlined align-middle text-sm">visibility</span>
                                        View
                                    </a>
                                    <a href="{{ route('admin.partners.edit', $partner) }}" class="text-primary hover:underline">
                                        <span class="material-symbols-outlined align-middle text-sm">edit</span>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this partner?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">
                                            <span class="material-symbols-outlined align-middle text-sm">delete</span>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                No partners found. <a href="{{ route('admin.partners.create') }}" class="text-primary hover:underline">Create your first partner</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($partners->hasPages())
            <div class="mt-6">
                {{ $partners->links() }}
            </div>
        @endif
    </main>
</x-admin-layout>
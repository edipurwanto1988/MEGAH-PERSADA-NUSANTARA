<x-admin-layout title="Users - Admin">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-900">Users Management</h1>
                <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-plus mr-2"></i>Create New User
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
                    <h3 class="text-lg leading-6 font-medium text-gray-900">All Users</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Manage system users here.</p>
                </div>
                <ul class="divide-y divide-gray-200">
                    @forelse($users as $user)
                        <li class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        @if($user->avatar)
                                            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="h-12 w-12 rounded-full object-cover">
                                        @else
                                            <div class="h-12 w-12 bg-gray-300 rounded-full flex items-center justify-center">
                                                <span class="text-gray-600 font-medium">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <h3 class="text-sm font-medium text-gray-900">
                                                {{ $user->name }}
                                                @if($user->id === auth()->id())
                                                    <span class="ml-2 inline-flex px-2 py-0.5 text-xs font-medium rounded bg-blue-100 text-blue-800">(You)</span>
                                                @endif
                                            </h3>
                                            <div class="mt-1 flex items-center space-x-4">
                                                <span class="text-sm text-gray-500">
                                                    {{ $user->email }}
                                                </span>
                                                <span class="text-sm text-gray-500">
                                                    Role: <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : ($user->role == 'editor' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                        {{ ucfirst($user->role) }}
                                                    </span>
                                                </span>
                                                <span class="text-sm text-gray-500">
                                                    Status: <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $user->status }}
                                                    </span>
                                                </span>
                                                <span class="text-sm text-gray-500">
                                                    Joined: {{ $user->created_at->format('M d, Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash mr-1"></i>Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="px-4 py-8 text-center text-gray-500">
                            No users found. <a href="{{ route('admin.users.create') }}" class="text-blue-600 hover:text-blue-900">Create your first user</a>.
                        </li>
                    @endforelse
                </ul>

                <!-- Pagination -->
                @if($users->hasPages())
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            {{ $users->links() }}
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">{{ $users->firstItem() }}</span>
                                    to
                                    <span class="font-medium">{{ $users->lastItem() }}</span>
                                    of
                                    <span class="font-medium">{{ $users->total() }}</span>
                                    results
                                </p>
                            </div>
                            <div>
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
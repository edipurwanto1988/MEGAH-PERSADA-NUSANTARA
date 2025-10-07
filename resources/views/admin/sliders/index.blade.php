<x-admin-layout title="Sliders - Admin">
    <main class="flex-1 container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Sliders</h2>
            <a href="{{ route('admin.sliders.create') }}" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90">
                <span class="material-symbols-outlined">add</span>
                Add Slider
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-background-dark rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Order</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-background-dark divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($sliders as $slider)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($slider->image_url)
                                        <img src="{{ asset('storage/' . $slider->image_url) }}" alt="{{ $slider->title }}" class="h-16 w-24 object-cover rounded">
                                    @else
                                        <div class="h-16 w-24 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center">
                                            <span class="text-gray-400 dark:text-gray-500 text-xs">No Image</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $slider->title }}</div>
                                    @if($slider->subtitle)
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $slider->subtitle }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $slider->status === 'active' ? 'bg-primary/20 text-primary-800 dark:bg-primary/30 dark:text-primary-200' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300' }}">
                                        {{ $slider->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $slider->order_no }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('admin.sliders.show', $slider) }}" class="text-primary hover:underline">
                                            <span class="material-symbols-outlined align-middle text-sm">visibility</span>
                                            View
                                        </a>
                                        <a href="{{ route('admin.sliders.edit', $slider) }}" class="text-primary hover:underline">
                                            <span class="material-symbols-outlined align-middle text-sm">edit</span>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this slider?')" class="inline">
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
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    No sliders found. <a href="{{ route('admin.sliders.create') }}" class="text-primary hover:underline">Create your first slider</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</x-admin-layout>
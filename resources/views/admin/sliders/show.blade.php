<x-admin-layout title="Slider Details - Admin">
    <main class="flex-1 container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mb-2">
                    <a href="{{ route('admin.sliders.index') }}" class="hover:text-primary">Sliders</a>
                    <span>/</span>
                    <span>{{ $slider->title }}</span>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Slider Details</h2>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.sliders.edit', $slider) }}" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90">
                    <span class="material-symbols-outlined">edit</span>
                    Edit Slider
                </a>
                <a href="{{ route('admin.sliders.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Back to Sliders
                </a>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Slider Image -->
            <div class="bg-white dark:bg-background-dark rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Slider Image</h3>
                @if($slider->image_url)
                    <div class="flex justify-center">
                        <img src="{{ asset('storage/' . $slider->image_url) }}" alt="{{ $slider->title }}" class="max-w-full h-auto rounded-lg shadow-md">
                    </div>
                @else
                    <div class="flex justify-center">
                        <div class="h-64 w-full bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400 dark:text-gray-500">No Image Available</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Slider Information -->
            <div class="bg-white dark:bg-background-dark rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Slider Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Title</h4>
                        <p class="text-gray-900 dark:text-white">{{ $slider->title }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Subtitle</h4>
                        <p class="text-gray-900 dark:text-white">{{ $slider->subtitle ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Button Text</h4>
                        <p class="text-gray-900 dark:text-white">{{ $slider->button_text ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Button Link</h4>
                        <p class="text-gray-900 dark:text-white">{{ $slider->button_link ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Order</h4>
                        <p class="text-gray-900 dark:text-white">{{ $slider->order_no }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Status</h4>
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $slider->status === 'active' ? 'bg-primary/20 text-primary-800 dark:bg-primary/30 dark:text-primary-200' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300' }}">
                            {{ $slider->status }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-4">
                <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this slider? This action cannot be undone.')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-2 bg-red-500 text-white rounded-lg font-medium hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete Slider
                    </button>
                </form>
                <a href="{{ route('admin.sliders.edit', $slider) }}" class="px-6 py-2 bg-primary text-white rounded-lg font-medium hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Edit Slider
                </a>
            </div>
        </div>
    </main>
</x-admin-layout>
<x-admin-layout title="{{ $page->title }} - Admin">
    <main class="flex-1 container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mb-4">
                <a href="{{ route('admin.pages.index') }}" class="hover:text-primary">Pages</a>
                <span>/</span>
                <span>{{ $page->title }}</span>
            </div>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $page->title }}</h2>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.pages.edit', $page) }}" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90">
                        <span class="material-symbols-outlined">edit</span>
                        Edit Page
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-background-dark rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Slug</h3>
                        <p class="text-gray-800 dark:text-gray-200">{{ $page->slug }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Status</h3>
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $page->status === 'active' ? 'bg-primary/20 text-primary-800 dark:bg-primary/30 dark:text-primary-200' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300' }}">
                            {{ $page->status }}
                        </span>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Created</h3>
                        <p class="text-gray-800 dark:text-gray-200">{{ $page->created_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Last Updated</h3>
                        <p class="text-gray-800 dark:text-gray-200">{{ $page->updated_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                    @if($page->template)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Template</h3>
                        <p class="text-gray-800 dark:text-gray-200">{{ $page->template }}</p>
                    </div>
                    @endif
                </div>
            </div>

            @if($page->featured_image)
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Featured Image</h3>
                <div class="max-w-md">
                    <img src="{{ asset('storage/' . $page->featured_image) }}" alt="{{ $page->title }}" class="w-full rounded-lg border border-gray-200 dark:border-gray-700">
                </div>
            </div>
            @endif

            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Content</h3>
                <div class="prose prose-sm dark:prose-invert max-w-none">
                    {!! $page->content !!}
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this page? This action cannot be undone.')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-medium hover:bg-red-600">
                        <span class="material-symbols-outlined">delete</span>
                        Delete Page
                    </button>
                </form>
            </div>
            <a href="{{ route('admin.pages.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600">
                Back to Pages
            </a>
        </div>
    </main>
</x-admin-layout>
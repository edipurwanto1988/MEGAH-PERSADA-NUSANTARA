<x-admin-layout title="{{ $post->title }} - Admin">
    <main class="flex-1 container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $post->title }}</h2>
                <div class="mt-2 flex flex-wrap items-center gap-4">
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Category: {{ $post->category->name ?? 'Uncategorized' }}
                    </span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Author: {{ $post->author->name ?? 'Unknown' }}
                    </span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Created: {{ $post->created_at->format('M d, Y H:i') }}
                    </span>
                    @if($post->published_at)
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Published: {{ $post->published_at->format('M d, Y H:i') }}
                        </span>
                    @endif
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $post->status === 'published' ? 'bg-primary/20 text-primary-800 dark:bg-primary/30 dark:text-primary-200' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300' }}">
                        {{ $post->status }}
                    </span>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.posts.edit', $post) }}" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700">
                        <i class="fas fa-trash"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white dark:bg-background-dark shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Post Details</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Full post content and metadata.</p>
            </div>
            <div class="p-6">
                <dl class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Slug</dt>
                        <dd class="md:col-span-2 text-sm text-gray-900 dark:text-gray-200">{{ $post->slug }}</dd>
                    </div>
                    
                    @if($post->excerpt)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Excerpt</dt>
                        <dd class="md:col-span-2 text-sm text-gray-900 dark:text-gray-200">{{ $post->excerpt }}</dd>
                    </div>
                    @endif

                    @if($post->featured_image)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Featured Image</dt>
                        <dd class="md:col-span-2">
                            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="h-48 w-auto object-cover rounded-lg">
                        </dd>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Content</dt>
                        <dd class="text-sm text-gray-900 dark:text-gray-200">
                            <div class="prose max-w-none dark:prose-invert">
                                {!! $post->content !!}
                            </div>
                        </dd>
                    </div>

                    @if($post->tags)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tags</dt>
                        <dd class="md:col-span-2 text-sm text-gray-900 dark:text-gray-200">{{ $post->tags }}</dd>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">SEO Title</dt>
                        <dd class="md:col-span-2 text-sm text-gray-900 dark:text-gray-200">{{ $post->seo_title ?? 'Not set' }}</dd>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">SEO Description</dt>
                        <dd class="md:col-span-2 text-sm text-gray-900 dark:text-gray-200">{{ $post->seo_description ?? 'Not set' }}</dd>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">SEO Keywords</dt>
                        <dd class="md:col-span-2 text-sm text-gray-900 dark:text-gray-200">{{ $post->seo_keywords ?? 'Not set' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-arrow-left"></i>
                Back to Posts
            </a>
        </div>
    </main>
</x-admin-layout>
<x-web-layout :title="$page->title" :metaDescription="Str::limit(strip_tags($page->content), 160)">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $page->title }}</h1>
            <div class="prose max-w-none">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</x-web-layout>
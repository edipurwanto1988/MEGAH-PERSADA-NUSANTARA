<x-web-layout :title="setting('company_name', $companyProfile->company_name) . ' - Artikel'" :metaDescription="setting('meta_description')">
    <!-- Hero Section -->
    <section class="relative h-[40vh] min-h-[300px] bg-cover bg-center" style='background-image: linear-gradient(to top, rgba(0, 0, 0, 0.5), transparent), url("https://picsum.photos/seed/articles/1920/600.jpg");'>
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">
                    @if(isset($category))
                        {{ $category->name }}
                    @else
                        Artikel
                    @endif
                </h1>
                <p class="text-xl text-white/90">
                    @if(isset($category))
                        Temukan informasi dan tips bermanfaat seputar {{ $category->name }}
                    @else
                        Temukan informasi dan tips bermanfaat seputar produk kami
                    @endif
                </p>
            </div>
        </div>
    </section>

    <!-- Articles Section -->
    <section class="bg-background-light dark:bg-background-dark py-16 sm:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <!-- Categories Filter -->
                @if($categories->count() > 0)
                <div class="mb-8">
                    <div class="flex flex-wrap gap-2 justify-center">
                        <a href="/artikel" class="px-4 py-2 rounded-full @if(!isset($category)) bg-primary text-white @else bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 @endif hover:bg-primary/90 transition-colors">Semua</a>
                        @foreach($categories as $cat)
                            <a href="/artikel/category/{{ $cat->slug }}" class="px-4 py-2 rounded-full @if(isset($category) && $category->id === $cat->id) bg-primary text-white @else bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 @endif hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors">{{ $cat->name }}</a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Articles Grid -->
                @if($articles->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @foreach($articles as $article)
                            <div class="bg-background-light-alt dark:bg-background-dark-alt rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300">
                                @if($article->featured_image)
                                    <div class="w-full aspect-video bg-cover bg-center" style='background-image: url("{{ Storage::url($article->featured_image) }}");'></div>
                                @else
                                    <div class="w-full aspect-video bg-cover bg-center" style='background-image: url("https://picsum.photos/seed/article{{ $article->id }}/400/300.jpg");'></div>
                                @endif
                                <div class="p-6">
                                    <div class="mb-2">
                                        <span class="text-sm font-medium text-primary">{{ $article->category->name ?? 'Uncategorized' }}</span>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">{{ $article->title }}</h3>
                                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">{{ $article->excerpt ? Str::limit($article->excerpt, 100) : Str::limit(strip_tags($article->content), 100) }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-slate-500 dark:text-slate-400">{{ date('d M Y', strtotime($article->published_date)) }}</span>
                                        <a href="/artikel/{{ $article->slug }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90 transition text-sm">Baca Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center">
                        {{ $articles->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-xl text-slate-600 dark:text-slate-400">Belum ada artikel yang tersedia.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-web-layout>
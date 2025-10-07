<x-web-layout :title="$article->title . ' - ' . $companyProfile->company_name">
    <main class="flex-grow bg-white">
        <div class="font-display" style="font-family: 'Newsreader', serif;">
            <div class="container mx-auto px-6 py-12 lg:py-20">
            <div class="max-w-4xl mx-auto">
                <!-- Breadcrumb -->
                <div class="mb-8">
                    <p class="text-primary font-semibold mb-2">
                        <a class="hover:underline" href="/articles">Resources</a>
                        <span class="text-subtle-light dark:text-subtle-dark mx-2">/</span>
                        <span>{{ $article->category_name }}</span>
                    </p>
                    <h1 class="text-4xl lg:text-6xl font-extrabold leading-tight tracking-tighter mb-4">
                        {{ $article->title }}
                    </h1>
                    <p class="text-lg text-subtle-light dark:text-subtle-dark">By {{ $article->author->name }} · Published on {{ date('F d, Y', strtotime($article->published_at)) }}</p>
                </div>
                
                <!-- Article Image -->
                @if($article->featured_image)
                <div class="w-full h-auto aspect-video lg:aspect-[2/1] rounded-xl overflow-hidden mb-12">
                    <img alt="{{ $article->title }}" class="w-full h-full object-cover" src="{{ Storage::url($article->featured_image) }}"/>
                </div>
                @endif
                
                <!-- Article Content -->
                <article class="prose prose-xl lg:prose-2xl max-w-none text-foreground-light dark:text-foreground-dark">
                    {!! $article->content !!}
                </article>
                
                <hr class="my-16 border-gray-200 dark:border-gray-800"/>
                
                <!-- Related Articles -->
                <div>
                    <h2 class="text-3xl lg:text-4xl font-bold mb-8">Related Articles</h2>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        @foreach($relatedArticles as $related)
                            <a class="group block" href="/articles/{{ $related->slug }}">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="w-full aspect-square rounded-lg overflow-hidden">
                                        @if($related->featured_image)
                                        <img alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" src="{{ Storage::url($related->featured_image) }}"/>
                                        @else
                                        <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                            <span class="text-gray-400 dark:text-gray-500">No Image</span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col justify-center gap-1">
                                        <p class="text-sm text-primary font-semibold">{{ $related->category->name ?? 'Uncategorized' }}</p>
                                        <h3 class="text-lg font-bold leading-tight group-hover:text-primary transition-colors">{{ $related->title }}</h3>
                                        <p class="text-subtle-light dark:text-subtle-dark text-sm">{{ Str::limit(strip_tags($related->content), 100) }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
</x-web-layout>
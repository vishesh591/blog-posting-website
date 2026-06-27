<article class="glass-panel card-hover overflow-hidden flex flex-col justify-between h-full">
    <div>
        @if($blog->featured_image_path)
            <div class="h-48 w-full overflow-hidden border-b border-zinc-800">
                <img src="{{ Str::startsWith($blog->featured_image_path, ['http://', 'https://']) ? $blog->featured_image_path : asset('storage/' . $blog->featured_image_path) }}" alt="{{ $blog->title }}" class="h-full w-full object-cover transition-transform duration-300 hover:scale-105">
            </div>
        @else
            <div class="h-48 bg-zinc-900/40 border-b border-zinc-800 flex items-center justify-center">
                <span class="text-xl font-serif text-zinc-600">InkPress</span>
            </div>
        @endif
        <div class="p-5">
            <div class="mb-3 flex items-center gap-2 text-xs text-zinc-400">
                <span>{{ optional($blog->category)->name ?? 'General' }}</span>
                <span>•</span>
                <span>{{ $blog->reading_time }} min read</span>
            </div>
            <a href="{{ route('blogs.show', $blog->slug) }}" class="text-lg font-bold text-zinc-100 hover:text-orange-400 transition-colors duration-200 line-clamp-2 block">{{ $blog->title }}</a>
            <p class="mt-2 text-sm text-zinc-400 line-clamp-3 leading-relaxed">{{ $blog->excerpt }}</p>
        </div>
    </div>
    <div class="px-5 pb-5 pt-3 border-t border-zinc-900/40 flex items-center justify-between text-xs text-zinc-400">
        <span class="font-medium text-zinc-300">{{ $blog->author->name }}</span>
        <span>{{ $blog->published_at?->format('M d, Y') ?? $blog->created_at->format('M d, Y') }}</span>
    </div>
</article>

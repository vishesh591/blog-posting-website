<article class="glass-panel card-hover overflow-hidden">
    @if($blog->featured_image_path)
        <div class="h-52 w-full overflow-hidden">
            <img src="{{ Str::startsWith($blog->featured_image_path, ['http://', 'https://']) ? $blog->featured_image_path : asset('storage/' . $blog->featured_image_path) }}" alt="{{ $blog->title }}" class="h-full w-full object-cover transition-transform duration-300 hover:scale-105">
        </div>
    @else
        <div class="h-52 bg-gradient-to-br from-orange-500/30 via-sky-500/10 to-emerald-500/20"></div>
    @endif
    <div class="p-6">
        <div class="mb-3 flex items-center gap-2 text-xs text-slate-400">
            <span>{{ optional($blog->category)->name ?? 'General' }}</span>
            <span>•</span>
            <span>{{ $blog->reading_time }} min read</span>
        </div>
        <a href="{{ route('blogs.show', $blog->slug) }}" class="text-2xl font-bold">{{ $blog->title }}</a>
        <p class="mt-3 text-sm text-slate-400">{{ $blog->excerpt }}</p>
        <div class="mt-5 flex items-center justify-between text-sm text-slate-400">
            <span>{{ $blog->author->name }}</span>
            <span>{{ $blog->published_at?->format('M d, Y') ?? $blog->created_at->format('M d, Y') }}</span>
        </div>
    </div>
</article>

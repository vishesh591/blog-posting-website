@extends('layouts.app')

@section('content')
<section class="section-shell py-8 md:py-16">
    <!-- Hero Header Split Layout -->
    <div class="grid gap-8 items-center {{ $blog->featured_image_path ? 'lg:grid-cols-[1.2fr_0.8fr]' : 'text-center max-w-4xl mx-auto' }}">
        <div class="reveal">
            <span class="eyebrow mb-4">{{ optional($blog->category)->name ?? 'General' }}</span>
            <h1 class="mt-4 text-2xl font-bold sm:text-3xl md:text-4xl tracking-tight leading-tight heading-gradient">
                {{ $blog->title }}
            </h1>
            <p class="mt-6 text-lg md:text-xl text-slate-300 leading-relaxed font-light">
                {{ $blog->excerpt }}
            </p>
            
            <div class="mt-8 flex flex-wrap items-center gap-4 text-sm text-slate-400 {{ $blog->featured_image_path ? '' : 'justify-center' }}">
                <span class="inline-flex items-center gap-2">
                    <img src="{{ $blog->author->avatar_url }}" alt="{{ $blog->author->name }}" class="h-8 w-8 rounded-full object-cover border border-white/10">
                    <span class="font-semibold text-slate-200">By {{ $blog->author->name }}</span>
                </span>
                <span>•</span>
                <span>{{ $blog->published_at?->format('M d, Y') ?? $blog->created_at->format('M d, Y') }}</span>
                <span>•</span>
                <span>{{ $blog->reading_time }} min read</span>
                <span>•</span>
                <span>{{ $blog->views_count }} views</span>
            </div>
            
            <div class="mt-8 flex flex-wrap gap-3 {{ $blog->featured_image_path ? '' : 'justify-center' }}">
                @auth
                    <button data-like-button data-endpoint="{{ route('blogs.like', $blog) }}" class="inline-flex items-center gap-2 rounded-2xl border border-white/10 px-4 py-2.5 text-sm hover:bg-white/10 hover:border-orange-500/30 transition-all duration-200 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 text-orange-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                        Like <span data-count class="font-semibold">{{ $blog->likes_count }}</span>
                    </button>
                    <button data-bookmark-button data-endpoint="{{ route('blogs.bookmark', $blog) }}" class="inline-flex items-center gap-2 rounded-2xl border border-white/10 px-4 py-2.5 text-sm hover:bg-white/10 hover:border-orange-500/30 transition-all duration-200 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 text-orange-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                        </svg>
                        Bookmark <span data-count class="font-semibold">{{ $blog->bookmarks_count }}</span>
                    </button>
                @endauth
            </div>
        </div>
        
        @if($blog->featured_image_path)
            <div class="w-full relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-orange-500 to-amber-500 rounded-3xl blur-2xl opacity-20 group-hover:opacity-30 transition-opacity duration-300"></div>
                <div class="relative overflow-hidden rounded-3xl border border-white/15 aspect-[4/3] w-full shadow-2xl">
                    <img src="{{ Str::startsWith($blog->featured_image_path, ['http://', 'https://']) ? $blog->featured_image_path : asset('storage/' . $blog->featured_image_path) }}" alt="{{ $blog->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                </div>
            </div>
        @endif
    </div>

    <!-- Main Content Split Layout -->
    <div class="mt-16 grid gap-12 lg:grid-cols-[250px_1fr] max-w-6xl mx-auto items-start">
        
        <!-- Left Side: Sticky Meta (desktop only) -->
        <div class="hidden lg:block sticky top-24 space-y-6">
            <div class="glass-panel p-6 space-y-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Written By</p>
                <div class="flex items-center gap-3">
                    <img src="{{ $blog->author->avatar_url }}" alt="{{ $blog->author->name }}" class="h-10 w-10 rounded-2xl object-cover border border-zinc-800">
                    <div>
                        <p class="font-semibold text-zinc-200 text-sm leading-tight">{{ $blog->author->name }}</p>
                        <p class="text-xs text-zinc-400 mt-1 leading-normal break-words">{{ $blog->author->headline ?: 'Author' }}</p>
                    </div>
                </div>
                <p class="text-xs text-zinc-400 leading-relaxed">{{ $blog->author->bio ?: 'An expert contributor to InkPress editorial.' }}</p>
            </div>
            
            <div class="glass-panel p-6 space-y-3">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Tags</p>
                <div class="flex flex-wrap gap-1.5">
                    @forelse($blog->tags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}" class="text-xs bg-white/5 hover:bg-orange-500/10 hover:text-orange-400 transition-colors border border-white/10 px-2.5 py-1 rounded-lg">#{{ $tag->name }}</a>
                    @empty
                        <span class="text-xs text-slate-500">No tags</span>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Side: Content Area -->
        <div class="space-y-10 min-w-0">
            <!-- AI Summary Accordion -->
            <details class="summary-accordion group overflow-hidden rounded-3xl border border-white/10 bg-white/8 transition-all duration-300">
                <summary class="flex cursor-pointer items-center justify-between p-6 font-semibold select-none text-slate-100 focus:outline-none bg-gradient-to-r from-orange-500/10 via-slate-900/30 to-slate-900/10 border-b border-white/5">
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-orange-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 21l8.982-11.795H13.62l1.382-7.205L6 13.795h5.196l-.383 2.109z" />
                        </svg>
                        Quick AI Summary
                    </span>
                    <svg class="h-5 w-5 text-slate-400 transition-transform duration-300 group-open:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </summary>
                <div class="p-6 bg-slate-950/20 text-slate-300 leading-relaxed text-sm">
                    @if($blog->summary)
                        <div class="summary-content" data-summary="{{ $blog->summary }}">
                            {!! Str::markdown($blog->summary) !!}
                        </div>
                    @else
                        <div class="flex flex-col gap-3 py-2">
                            <div class="flex items-center gap-2 text-slate-400 text-xs font-medium animate-pulse mb-1">
                                <svg class="animate-spin h-4 w-4 text-orange-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                AI is generating the summary...
                            </div>
                            <div class="skeleton-line h-3 w-11/12 rounded bg-white/5"></div>
                            <div class="skeleton-line h-3 w-10/12 rounded bg-white/5"></div>
                        </div>
                    @endif
                </div>
            </details>

            <!-- Blog Post Body -->
            <article class="glass-panel p-6 sm:p-10 leading-9 text-slate-300 text-base md:text-lg space-y-6">
                {!! $blog->body !!}
            </article>

            <!-- Tags section (mobile only) -->
            <div class="lg:hidden flex flex-wrap gap-2">
                @foreach($blog->tags as $tag)
                    <a href="{{ route('tags.show', $tag->slug) }}" class="text-xs bg-white/5 border border-white/10 px-2.5 py-1.5 rounded-lg text-slate-300">#{{ $tag->name }}</a>
                @endforeach
            </div>

            <!-- Comments Section -->
            <div class="pt-8">
                <h2 class="text-2xl font-bold tracking-tight text-white mb-6">Comments</h2>
                
                @if ($blog->allow_comments)
                    @auth
                        <form action="{{ route('comments.store', $blog) }}" method="POST" class="glass-panel p-6 space-y-4">
                            @csrf
                            <textarea name="body" rows="4" class="input-shell focus:border-orange-500" placeholder="Join the conversation..."></textarea>
                            <button class="btn-primary">Post comment</button>
                        </form>
                    @else
                        <div class="glass-panel p-6 text-center text-sm text-slate-400">
                            Please <a href="{{ route('login') }}" class="text-orange-400 hover:underline font-semibold">sign in</a> to join the conversation.
                        </div>
                    @endauth
                @else
                    <div class="glass-panel p-6 text-center text-sm text-slate-400">
                        Comments are closed for this story.
                    </div>
                @endif

                <div class="mt-8 space-y-4">
                    @forelse ($blog->comments as $comment)
                        <div class="glass-panel p-5">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-slate-200 text-sm">{{ $comment->user->name }}</span>
                                <span class="text-xs text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="mt-3 text-sm text-slate-300 leading-relaxed">{{ $comment->body }}</p>
                        </div>
                    @empty
                        <x-empty-state title="No comments yet" message="Be the first reader to start the discussion." />
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-shell py-10 border-t border-white/10">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-3xl font-bold">Related posts</h2>
    </div>
    <div class="grid gap-6 md:grid-cols-3">
        @foreach ($relatedBlogs as $relatedBlog)
            <x-blog-card :blog="$relatedBlog" />
        @endforeach
    </div>
</section>
@endsection

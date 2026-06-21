@extends('layouts.app')

@section('content')
<section class="section-shell py-16">
    <div class="mx-auto max-w-4xl">
        <p class="eyebrow">{{ optional($blog->category)->name ?? 'General' }}</p>
        <h1 class="mt-5 text-5xl font-bold">{{ $blog->title }}</h1>
        <p class="mt-5 text-xl text-slate-300">{{ $blog->excerpt }}</p>
        <div class="mt-8 flex flex-wrap items-center gap-4 text-sm text-slate-400">
            <span>By {{ $blog->author->name }}</span>
            <span>{{ $blog->published_at?->format('M d, Y') }}</span>
            <span>{{ $blog->reading_time }} min read</span>
            <span>{{ $blog->views_count }} views</span>
        </div>
        <div class="mt-8 flex gap-3">
            @auth
                <button data-like-button data-endpoint="{{ route('blogs.like', $blog) }}" class="rounded-2xl border border-white/10 px-4 py-2 text-sm">
                    Like <span data-count>{{ $blog->likes_count }}</span>
                </button>
                <button data-bookmark-button data-endpoint="{{ route('blogs.bookmark', $blog) }}" class="rounded-2xl border border-white/10 px-4 py-2 text-sm">
                    Bookmark <span data-count>{{ $blog->bookmarks_count }}</span>
                </button>
            @endauth
        </div>

        <details class="summary-accordion group mt-8 overflow-hidden rounded-3xl border border-white/10 bg-white/8 transition-all duration-300">
            <summary class="flex cursor-pointer items-center justify-between p-6 font-semibold select-none text-slate-100 focus:outline-none">
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
            <div class="border-t border-white/5 p-6 bg-slate-950/20 text-slate-300 leading-relaxed text-sm">
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
                        <div class="skeleton-line h-3 w-8/12 rounded bg-white/5"></div>
                    </div>
                @endif
            </div>
        </details>

        <article class="glass-panel mt-10 space-y-5 p-8 leading-8 text-slate-200">{!! $blog->body !!}</article>
        <div class="mt-12">
            <h2 class="text-2xl font-bold">Comments</h2>
            @if ($blog->allow_comments)
                @auth
                    <form action="{{ route('comments.store', $blog) }}" method="POST" class="glass-panel mt-5 space-y-4 p-6">
                        @csrf
                        <textarea name="body" rows="4" class="input-shell" placeholder="Join the conversation..."></textarea>
                        <button class="btn-primary">Post comment</button>
                    </form>
                @else
                    <div class="glass-panel mt-5 p-6 text-center text-sm text-slate-400">
                        Please <a href="{{ route('login') }}" class="text-orange-400 hover:underline font-semibold">sign in</a> to join the conversation and start the discussion.
                    </div>
                @endauth
            @else
                <div class="glass-panel mt-5 p-6 text-center text-sm text-slate-400">
                    Comments are closed for this story.
                </div>
            @endif
            <div class="mt-6 space-y-4">
                @forelse ($blog->comments as $comment)
                    <div class="glass-panel p-5">
                        <div class="flex items-center justify-between">
                            <p class="font-semibold">{{ $comment->user->name }}</p>
                            <p class="text-xs text-slate-400">{{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                        <p class="mt-3 text-slate-300">{{ $comment->body }}</p>
                    </div>
                @empty
                    <x-empty-state title="No comments yet" message="Be the first reader to start the discussion." />
                @endforelse
            </div>
        </div>
    </div>
</section>

<section class="section-shell py-10">
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

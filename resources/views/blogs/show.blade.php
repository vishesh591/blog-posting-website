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
        <article class="glass-panel mt-10 space-y-5 p-8 leading-8 text-slate-200">{!! $blog->body !!}</article>
        <div class="mt-12">
            <h2 class="text-2xl font-bold">Comments</h2>
            @auth
                <form action="{{ route('comments.store', $blog) }}" method="POST" class="glass-panel mt-5 space-y-4 p-6">
                    @csrf
                    <textarea name="body" rows="4" class="input-shell" placeholder="Join the conversation"></textarea>
                    <button class="btn-primary">Post comment</button>
                </form>
            @endauth
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

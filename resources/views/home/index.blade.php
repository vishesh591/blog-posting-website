@extends('layouts.app')

@section('content')
<section class="section-shell py-8 md:py-12">
    <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <div class="reveal">
            <span class="eyebrow">Modern Publishing Platform</span>
            <h1 class="mt-6 max-w-4xl text-5xl font-bold sm:text-7xl">Write, manage, and scale content with a premium editorial workflow.</h1>
            <p class="mt-6 max-w-2xl text-lg text-slate-300">InkPress blends author tools, analytics, media management, and audience engagement into one polished Laravel CMS.</p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('register') }}" class="btn-primary">Launch your newsroom</a>
                <a href="{{ route('blogs.index') }}" class="btn-secondary">Explore stories</a>
            </div>
        </div>
        <div class="glass-panel p-6">
            <div class="mb-4 flex items-center justify-between">
                <p class="text-sm text-slate-400">Search articles</p>
                <span class="rounded-full bg-emerald-400/15 px-3 py-1 text-xs text-emerald-300">Live</span>
            </div>
            <div class="relative">
                <input data-search-input data-target="#hero-search-results" class="input-shell" placeholder="Search by title, tag, category...">
                <div id="hero-search-results" class="glass-panel absolute left-0 right-0 top-16 hidden overflow-hidden"></div>
            </div>
            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <a href="{{ route('blogs.index') }}" class="rounded-2xl bg-zinc-900/30 border border-zinc-900 p-4 hover:bg-zinc-900/50 hover:border-zinc-700 transition-all duration-200 block text-left">
                    <p class="text-sm text-zinc-400">Featured stories</p>
                    <p class="mt-2 text-3xl font-bold text-zinc-100">{{ $featuredBlogs->count() }}</p>
                </a>
                <a href="#popular-authors-section" class="rounded-2xl bg-zinc-900/30 border border-zinc-900 p-4 hover:bg-zinc-900/50 hover:border-zinc-700 transition-all duration-200 block text-left">
                    <p class="text-sm text-zinc-400">Popular authors</p>
                    <p class="mt-2 text-3xl font-bold text-zinc-100">{{ $popularAuthors->count() }}</p>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="section-shell py-6 md:py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <p class="eyebrow">Featured</p>
            <h2 class="mt-4 text-3xl font-bold">Editorial picks that define the week.</h2>
        </div>
    </div>
    <div class="grid gap-6 lg:grid-cols-2">
        @foreach ($featuredBlogs as $blog)
            <x-blog-card :blog="$blog" />
        @endforeach
    </div>
</section>

<section class="section-shell grid gap-6 py-6 md:py-8 lg:grid-cols-[0.7fr_1.3fr]">
    <div class="glass-panel p-6">
        <p class="eyebrow">Trending now</p>
        <div class="mt-6 space-y-4">
            @forelse ($trendingBlogs as $blog)
                <a href="{{ route('blogs.show', $blog->slug) }}" class="block rounded-2xl border border-zinc-800 bg-zinc-900/10 hover:bg-zinc-900/50 hover:border-zinc-700 p-4 transition-all duration-200">
                    <p class="text-xs uppercase tracking-[0.2em] text-orange-400 font-semibold">{{ optional($blog->category)->name }}</p>
                    <p class="mt-2 text-lg font-semibold text-zinc-100">{{ $blog->title }}</p>
                    <p class="mt-2 text-sm text-zinc-400">{{ $blog->views_count }} views</p>
                </a>
            @empty
                <x-empty-state title="No trending stories yet" message="Seed the platform to highlight momentum." />
            @endforelse
        </div>
    </div>
    <div>
        <div class="mb-6 flex items-center justify-between">
            <div>
                <p class="eyebrow">Recent blogs</p>
                <h2 class="mt-4 text-3xl font-bold">Fresh writing from your publication.</h2>
            </div>
        </div>
        <div class="grid gap-6 md:grid-cols-2">
            @foreach ($recentBlogs as $blog)
                <x-blog-card :blog="$blog" />
            @endforeach
        </div>
    </div>
</section>

<section class="section-shell py-6 md:py-8">
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="glass-panel p-6 lg:col-span-2">
            <p class="eyebrow">Newsletter</p>
            <h2 class="mt-4 text-3xl font-bold">Stay on the pulse of product, engineering, and publishing.</h2>
            <form class="mt-6 flex flex-col gap-3 sm:flex-row">
                <input class="input-shell" placeholder="Enter your email">
                <button type="button" class="btn-primary">Subscribe</button>
            </form>
        </div>
        <div class="glass-panel p-6" id="popular-authors-section">
            <p class="eyebrow">Popular authors</p>
            <div class="mt-5 space-y-4">
                @foreach ($popularAuthors as $author)
                    <a href="{{ route('authors.show', $author->id) }}" class="flex items-center gap-4 rounded-2xl border border-zinc-800 bg-zinc-900/10 hover:bg-zinc-900/50 hover:border-zinc-700 p-3 transition-all duration-200">
                        <img src="{{ $author->avatar_url }}" alt="{{ $author->name }}" class="h-12 w-12 rounded-2xl object-cover border border-zinc-900">
                        <div>
                            <p class="font-semibold text-zinc-100">{{ $author->name }}</p>
                            <p class="text-sm text-zinc-400">{{ $author->headline ?: 'Author' }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection

@extends('layouts.app')

@section('content')
<section class="section-shell py-16">
    <div class="glass-panel p-8">
        <p class="eyebrow">Global search</p>
        <h1 class="mt-4 text-4xl font-bold">Results for "{{ $query }}"</h1>
        <form class="mt-6">
            <input name="q" value="{{ $query }}" data-search-input data-target="#search-suggestions" class="input-shell" placeholder="Search the platform">
            <div id="search-suggestions" class="glass-panel mt-3 hidden overflow-hidden"></div>
        </form>
    </div>
    <div class="mt-8 grid gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <h2 class="mb-4 text-2xl font-bold">Blogs</h2>
            <div class="space-y-4">
                @forelse ($results['blogs'] as $blog)
                    <x-blog-card :blog="$blog" />
                @empty
                    <x-empty-state title="No blog matches" message="Try a broader keyword." />
                @endforelse
            </div>
        </div>
        <div class="space-y-6">
            <div class="glass-panel p-6">
                <h3 class="text-xl font-bold">Categories</h3>
                <div class="mt-4 space-y-3">
                    @foreach ($results['categories'] as $category)
                        <a class="block text-sm text-slate-300" href="{{ route('categories.show', $category->slug) }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>
            <div class="glass-panel p-6">
                <h3 class="text-xl font-bold">Tags</h3>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($results['tags'] as $tag)
                        <a class="rounded-full border border-white/10 px-3 py-2 text-sm" href="{{ route('tags.show', $tag->slug) }}">#{{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

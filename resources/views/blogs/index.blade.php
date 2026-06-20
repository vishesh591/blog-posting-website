@extends('layouts.app')

@section('content')
<section class="section-shell py-16">
    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="eyebrow">All stories</p>
            <h1 class="mt-4 text-4xl font-bold">Discover deeply crafted articles.</h1>
        </div>
        <form class="grid gap-3 sm:grid-cols-3">
            <input name="search" value="{{ $filters['search'] ?? '' }}" class="input-shell" placeholder="Search title or content">
            <select name="category" class="input-shell">
                <option value="">All categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}" @selected(($filters['category'] ?? '') === $category->slug)>{{ $category->name }}</option>
                @endforeach
            </select>
            <select name="tag" class="input-shell">
                <option value="">All tags</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->slug }}" @selected(($filters['tag'] ?? '') === $tag->slug)>{{ $tag->name }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($blogs as $blog)
            <x-blog-card :blog="$blog" />
        @empty
            <div class="md:col-span-2 xl:col-span-3">
                <x-empty-state title="No stories found" message="Try adjusting the search or filter criteria." />
            </div>
        @endforelse
    </div>
    <div class="mt-8">{{ $blogs->links() }}</div>
</section>
@endsection

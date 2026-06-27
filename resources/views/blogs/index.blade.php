@extends('layouts.app')

@section('content')
<section class="section-shell py-8 md:py-12">
    <div class="mb-8 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="eyebrow">All stories</p>
            <h1 class="mt-4 text-4xl font-bold heading-gradient">Discover deeply crafted articles.</h1>
        </div>
        <form class="flex flex-col gap-3 sm:flex-row sm:items-center w-full lg:w-auto" id="filter-form">
            <input name="search" value="{{ $filters['search'] ?? '' }}" class="input-shell lg:w-64" placeholder="Search title or content">
            <select name="category" class="input-shell lg:w-44" onchange="this.form.submit()">
                <option value="">All categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}" @selected(($filters['category'] ?? '') === $category->slug)>{{ $category->name }}</option>
                @endforeach
            </select>
            <select name="tag" class="input-shell lg:w-44" onchange="this.form.submit()">
                <option value="">All tags</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->slug }}" @selected(($filters['tag'] ?? '') === $tag->slug)>{{ $tag->name }}</option>
                @endforeach
            </select>
            @if(request()->filled('search') || request()->filled('category') || request()->filled('tag'))
                <a href="{{ route('blogs.index') }}" class="btn-secondary py-2 px-4 h-10 flex items-center justify-center">
                    Clear
                </a>
            @endif
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

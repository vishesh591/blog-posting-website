@extends('layouts.dashboard')

@section('content')
<div class="flex items-center justify-between">
    <h1 class="text-3xl font-bold">{{ $blog->exists ? 'Edit blog' : 'Create blog' }}</h1>
    @if ($blog->exists)
        <a href="{{ route('dashboard.blogs.preview', $blog) }}" class="btn-secondary">Preview</a>
    @endif
</div>

<form action="{{ $blog->exists ? route('dashboard.blogs.update', $blog) : route('dashboard.blogs.store') }}" method="POST" class="mt-6 grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
    @csrf
    @if ($blog->exists)
        @method('PUT')
    @endif
    <div class="glass-panel p-6">
        <input name="title" value="{{ old('title', $blog->title) }}" class="input-shell text-lg" placeholder="Story title">
        <textarea name="excerpt" rows="3" class="input-shell mt-4" placeholder="Short excerpt">{{ old('excerpt', $blog->excerpt) }}</textarea>
        <textarea id="editor" name="body" rows="18" class="input-shell mt-4" placeholder="Write your story">{{ old('body', $blog->body) }}</textarea>
    </div>
    <div class="space-y-6">
        <div class="glass-panel p-6">
            <h2 class="text-xl font-bold">Publishing</h2>
            <div class="mt-4 space-y-4">
                <select name="status" class="input-shell">
                    @foreach (['draft', 'review', 'published'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $blog->status ?: 'draft') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <div class="relative flex items-center w-full">
                    <input id="scheduled_for" name="scheduled_for" type="datetime-local" value="{{ old('scheduled_for', optional($blog->scheduled_for)->format('Y-m-d\TH:i')) }}" class="input-shell pr-10">
                    <button type="button" class="absolute right-3 text-slate-400 hover:text-orange-400 transition-colors focus:outline-none" onclick="try { document.getElementById('scheduled_for').showPicker() } catch(e) {}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </button>
                </div>
                <select name="category_id" class="input-shell">
                    <option value="">Select category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $blog->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <select name="tag_ids[]" multiple class="input-shell min-h-40">
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" @selected(collect(old('tag_ids', $blog->tags->pluck('id') ?? []))->contains($tag->id))>{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="glass-panel p-6">
            <h2 class="text-xl font-bold">SEO & extras</h2>
            <div class="mt-4 space-y-4">
                <input name="seo_title" value="{{ old('seo_title', $blog->seo_title) }}" class="input-shell" placeholder="SEO title">
                <textarea name="seo_description" rows="3" class="input-shell" placeholder="SEO description">{{ old('seo_description', $blog->seo_description) }}</textarea>
                <input name="canonical_url" value="{{ old('canonical_url', $blog->canonical_url) }}" class="input-shell" placeholder="Canonical URL">
                <input name="featured_image_path" value="{{ old('featured_image_path', $blog->featured_image_path) }}" class="input-shell" placeholder="Featured image path or media URL">
                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="allow_comments" value="1" @checked(old('allow_comments', $blog->allow_comments ?? true))> Allow comments</label>
                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $blog->is_featured))> Featured blog</label>
                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_trending" value="1" @checked(old('is_trending', $blog->is_trending))> Trending highlight</label>
                <button class="btn-primary w-full">Save story</button>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.tinymce) {
        tinymce.init({
            selector: '#editor',
            height: 500,
            skin: 'oxide-dark',
            content_css: 'dark',
            menubar: false,
            plugins: 'link image lists table code preview',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | link image table | code preview'
        });
    }
});
</script>
@endsection

@extends('layouts.dashboard')

@section('content')
<div class="mx-auto max-w-4xl">
    <p class="eyebrow">Preview mode</p>
    <h1 class="mt-4 text-5xl font-bold">{{ $blog->title }}</h1>
    <p class="mt-4 text-slate-400">{{ $blog->excerpt }}</p>
    @if($blog->featured_image_path)
        <div class="mt-6 overflow-hidden rounded-3xl border border-white/10 w-full h-[300px] sm:h-[400px]">
            <img src="{{ Str::startsWith($blog->featured_image_path, ['http://', 'https://']) ? $blog->featured_image_path : asset('storage/' . $blog->featured_image_path) }}" alt="{{ $blog->title }}" class="h-full w-full object-cover">
        </div>
    @endif
    <article class="glass-panel mt-10 space-y-5 p-8 leading-8 text-slate-200">{!! $blog->body !!}</article>
</div>
@endsection

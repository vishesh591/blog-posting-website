@extends('layouts.dashboard')

@section('content')
<div class="mx-auto max-w-4xl">
    <p class="eyebrow">Preview mode</p>
    <h1 class="mt-4 text-5xl font-bold">{{ $blog->title }}</h1>
    <p class="mt-4 text-slate-400">{{ $blog->excerpt }}</p>
    <article class="glass-panel mt-10 space-y-5 p-8 leading-8 text-slate-200">{!! $blog->body !!}</article>
</div>
@endsection

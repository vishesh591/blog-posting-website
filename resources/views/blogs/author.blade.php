@extends('layouts.app')

@section('content')
<section class="section-shell py-16">
    <div class="glass-panel p-8">
        <div class="flex flex-col gap-6 md:flex-row md:items-center">
            <img src="{{ $authorProfile->avatar_url }}" alt="{{ $authorProfile->name }}" class="h-24 w-24 rounded-3xl object-cover">
            <div>
                <h1 class="text-4xl font-bold">{{ $authorProfile->name }}</h1>
                <p class="mt-2 text-slate-300">{{ $authorProfile->headline ?: 'Author' }}</p>
                <p class="mt-4 max-w-2xl text-slate-400">{{ $authorProfile->bio }}</p>
            </div>
        </div>
    </div>
    <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @foreach ($authorProfile->blogs as $blog)
            <x-blog-card :blog="$blog" />
        @endforeach
    </div>
</section>
@endsection

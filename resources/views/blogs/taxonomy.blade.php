@extends('layouts.app')

@section('content')
<section class="section-shell py-16">
    <p class="eyebrow">{{ $title }}</p>
    <h1 class="mt-4 text-4xl font-bold">{{ ucfirst($slug) }}</h1>
    <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($blogs as $blog)
            <x-blog-card :blog="$blog" />
        @empty
            <div class="md:col-span-2 xl:col-span-3">
                <x-empty-state title="Nothing here yet" message="This topic will fill up as content grows." />
            </div>
        @endforelse
    </div>
</section>
@endsection

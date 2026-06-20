@extends('layouts.dashboard')

@section('content')
<div class="grid gap-8 xl:grid-cols-[0.7fr_1.3fr]">
    <div class="glass-panel p-6">
        <h1 class="text-3xl font-bold">Tags</h1>
        <form method="POST" action="{{ route('dashboard.tags.store') }}" class="mt-6 space-y-4">
            @csrf
            <input name="name" class="input-shell" placeholder="Tag name">
            <button class="btn-primary">Save tag</button>
        </form>
    </div>
    <div class="glass-panel p-6">
        <div class="flex flex-wrap gap-3">
            @foreach ($tags as $tag)
                <form action="{{ route('dashboard.tags.destroy', $tag) }}" method="POST" class="rounded-full border border-white/10 px-4 py-2">
                    @csrf
                    @method('DELETE')
                    <span>#{{ $tag->name }} ({{ $tag->blogs_count }})</span>
                    <button class="ml-3 text-xs text-red-300">Delete</button>
                </form>
            @endforeach
        </div>
    </div>
</div>
@endsection

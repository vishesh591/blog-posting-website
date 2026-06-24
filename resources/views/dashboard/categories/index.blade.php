@extends('layouts.dashboard')

@section('content')
<div class="grid gap-6 xl:grid-cols-[0.7fr_1.3fr]">
    <div class="glass-panel p-6">
        <h1 class="text-3xl font-bold heading-gradient">Categories</h1>
        <form method="POST" action="{{ route('dashboard.categories.store') }}" class="mt-6 space-y-4">
            @csrf
            <input name="name" class="input-shell" placeholder="Category name">
            <textarea name="description" rows="3" class="input-shell" placeholder="Description"></textarea>
            <input name="color" class="input-shell" placeholder="#0f172a">
            <button class="btn-primary">Save category</button>
        </form>
    </div>
    <div class="glass-panel p-6">
        <div class="space-y-4">
            @foreach ($categories as $category)
                <div class="flex items-center justify-between rounded-2xl border border-white/10 p-4">
                    <div>
                        <p class="font-semibold">{{ $category->name }}</p>
                        <p class="text-sm text-slate-400">{{ $category->blogs_count }} blogs</p>
                    </div>
                    <form action="{{ route('dashboard.categories.destroy', $category) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn-secondary px-3 py-2">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

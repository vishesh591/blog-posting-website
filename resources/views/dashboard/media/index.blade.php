@extends('layouts.dashboard')

@section('content')
<div class="grid gap-6 xl:grid-cols-[0.7fr_1.3fr]">
    <div class="glass-panel p-6">
        <h1 class="text-3xl font-bold heading-gradient">Media library</h1>
        <form action="{{ route('dashboard.media.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
            @csrf
            <input type="file" name="file" class="input-shell" data-media-upload>
            <input name="alt_text" class="input-shell" placeholder="Alt text">
            <button type="button" class="btn-secondary w-full">Drag & drop ready</button>
        </form>
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        @forelse ($mediaItems as $item)
            <div class="glass-panel p-4">
                <div class="skeleton h-40 w-full"></div>
                <p class="mt-4 truncate font-semibold">{{ $item->file_name }}</p>
                <p class="mt-1 text-sm text-slate-400">{{ number_format($item->size / 1024, 1) }} KB</p>
                <div class="mt-4 flex gap-2">
                    <a href="{{ route('dashboard.media.download', $item) }}" class="btn-secondary px-3 py-2">Download</a>
                    <form method="POST" action="{{ route('dashboard.media.destroy', $item) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn-secondary px-3 py-2">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="md:col-span-2">
                <x-empty-state title="No media files" message="Upload assets to power featured images and galleries." />
            </div>
        @endforelse
    </div>
</div>
<div class="mt-6">{{ $mediaItems->links() }}</div>
@endsection

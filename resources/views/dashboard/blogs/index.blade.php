@extends('layouts.dashboard')

@section('content')
<div class="flex items-center justify-between">
    <h1 class="text-3xl font-bold heading-gradient">Blog management</h1>
    <a href="{{ route('dashboard.blogs.create') }}" class="btn-primary">Create blog</a>
</div>
<div class="mt-6 overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-900/10">
    <table class="min-w-full text-left text-sm">
        <thead class="bg-zinc-900/60 text-zinc-400">
            <tr class="border-b border-zinc-800">
                <th class="px-5 py-4 font-semibold text-xs uppercase tracking-wider text-zinc-400">Title</th>
                <th class="px-5 py-4 font-semibold text-xs uppercase tracking-wider text-zinc-400">Status</th>
                <th class="px-5 py-4 font-semibold text-xs uppercase tracking-wider text-zinc-400">Category</th>
                <th class="px-5 py-4 font-semibold text-xs uppercase tracking-wider text-zinc-400">Views</th>
                <th class="px-5 py-4"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($blogs as $blog)
                <tr class="border-t border-zinc-800/80 hover:bg-zinc-900/20 transition-colors">
                    <td class="px-5 py-4">{{ $blog->title }}</td>
                    <td class="px-5 py-4">{{ ucfirst($blog->status) }}</td>
                    <td class="px-5 py-4">{{ optional($blog->category)->name ?? 'General' }}</td>
                    <td class="px-5 py-4">{{ $blog->views_count }}</td>
                    <td class="px-5 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('dashboard.blogs.edit', $blog) }}" class="btn-secondary px-3 py-2">Edit</a>
                            <a href="{{ route('dashboard.blogs.preview', $blog) }}" class="btn-secondary px-3 py-2">Preview</a>
                            <form method="POST" action="{{ route('dashboard.blogs.destroy', $blog) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn-secondary px-3 py-2">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-5 py-8"><x-empty-state title="No blogs yet" message="Create your first article to populate the dashboard." /></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $blogs->links() }}</div>
@endsection

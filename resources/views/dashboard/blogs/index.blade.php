@extends('layouts.dashboard')

@section('content')
<div class="flex items-center justify-between">
    <h1 class="text-3xl font-bold heading-gradient">Blog management</h1>
    <a href="{{ route('dashboard.blogs.create') }}" class="btn-primary">Create blog</a>
</div>
<div class="mt-6 overflow-hidden rounded-3xl border border-white/10">
    <table class="min-w-full text-left text-sm">
        <thead class="bg-white/5 text-slate-400">
            <tr>
                <th class="px-5 py-4">Title</th>
                <th class="px-5 py-4">Status</th>
                <th class="px-5 py-4">Category</th>
                <th class="px-5 py-4">Views</th>
                <th class="px-5 py-4"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($blogs as $blog)
                <tr class="border-t border-white/10">
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

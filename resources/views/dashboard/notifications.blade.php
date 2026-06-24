@extends('layouts.dashboard')

@section('content')
<div class="flex items-center justify-between">
    <h1 class="text-3xl font-bold heading-gradient">Notifications</h1>
    <form method="POST" action="{{ route('dashboard.notifications.read') }}">
        @csrf
        <button class="btn-secondary">Mark all as read</button>
    </form>
</div>
<div class="mt-6 space-y-4">
    @forelse ($notifications as $notification)
        <div class="glass-panel p-5">
            <div class="flex items-center justify-between">
                <p class="font-semibold">{{ $notification->data['title'] ?? 'Notification' }}</p>
                <p class="text-xs text-slate-400">{{ $notification->created_at->diffForHumans() }}</p>
            </div>
            <p class="mt-2 text-sm text-slate-400">{{ $notification->data['message'] ?? '' }}</p>
        </div>
    @empty
        <x-empty-state title="All quiet here" message="No notifications have landed yet." />
    @endforelse
</div>
@endsection

@extends('layouts.dashboard')

@section('content')
<div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
    <x-stat-card label="Total users" :value="$stats['total_users']" />
    <x-stat-card label="Total blogs" :value="$stats['total_blogs']" />
    <x-stat-card label="Published blogs" :value="$stats['published_blogs']" />
    <x-stat-card label="Draft blogs" :value="$stats['draft_blogs']" />
</div>

<div class="mt-6 grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
    <div class="glass-panel p-6">
        <div class="mb-5 flex items-center justify-between">
            <h2 class="text-2xl font-bold heading-gradient">Most viewed blogs</h2>
            @if (in_array(auth()->user()->role, ['admin', 'author']))
                <a href="{{ route('dashboard.blogs.index') }}" class="text-sm text-orange-300">Manage blogs</a>
            @endif
        </div>
        <div class="space-y-4">
            @forelse ($stats['most_viewed'] as $blog)
                @if (is_array($blog))
                    <a href="{{ route('blogs.show', $blog['slug']) }}" class="flex items-center justify-between rounded-2xl border border-white/10 p-4 hover:border-orange-400/50 hover:bg-white/5 transition-all duration-200 block">
                        <div>
                            <p class="font-semibold text-slate-200 hover:text-orange-400 transition-colors">{{ $blog['title'] }}</p>
                            <p class="text-sm text-slate-400">{{ $blog['author']['name'] ?? 'Unknown' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-slate-200">{{ $blog['views_count'] }}</p>
                            <p class="text-xs text-slate-400">views</p>
                        </div>
                    </a>
                @endif
            @empty
                <x-empty-state title="No analytics yet" message="Create and publish content to start seeing traction." />
            @endforelse
        </div>
    </div>
    <div class="glass-panel p-6">
        <h2 class="text-2xl font-bold heading-gradient">Recent activity</h2>
        <div class="mt-5 space-y-4">
            @foreach ($stats['recent_activities'] as $activity)
                @if (is_array($activity) || is_object($activity))
                    @php
                        $label = is_array($activity) ? ($activity['label'] ?? '') : ($activity->label ?? '');
                        $description = is_array($activity) ? ($activity['description'] ?? '') : ($activity->description ?? '');
                        $time = is_array($activity) ? ($activity['time'] ?? null) : ($activity->time ?? null);
                    @endphp
                    <div class="rounded-2xl border border-white/10 p-4">
                        <p class="text-sm font-semibold">{{ $label }}</p>
                        <p class="mt-1 text-sm text-slate-400">{{ $description }}</p>
                        @if ($time instanceof \Carbon\Carbon || (is_object($time) && method_exists($time, 'diffForHumans')))
                            <p class="mt-2 text-xs text-slate-500">{{ $time->diffForHumans() }}</p>
                        @elseif ($time)
                            <p class="mt-2 text-xs text-slate-500">{{ $time }}</p>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection

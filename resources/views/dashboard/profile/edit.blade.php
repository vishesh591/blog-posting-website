@extends('layouts.dashboard')

@section('content')
<div class="grid gap-6 xl:grid-cols-2">
    <div class="glass-panel p-6">
        <h1 class="text-3xl font-bold heading-gradient">Profile settings</h1>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
            @csrf
            @method('PUT')
            <input name="name" value="{{ auth()->user()->name }}" class="input-shell" placeholder="Name">
            <input name="headline" value="{{ auth()->user()->headline }}" class="input-shell" placeholder="Headline">
            <textarea name="bio" rows="5" class="input-shell" placeholder="Bio">{{ auth()->user()->bio }}</textarea>
            <input name="social_links[twitter]" value="{{ auth()->user()->social_links['twitter'] ?? '' }}" class="input-shell" placeholder="Twitter URL">
            <input name="social_links[linkedin]" value="{{ auth()->user()->social_links['linkedin'] ?? '' }}" class="input-shell" placeholder="LinkedIn URL">
            <input name="social_links[website]" value="{{ auth()->user()->social_links['website'] ?? '' }}" class="input-shell" placeholder="Website URL">
            <input name="avatar" type="file" class="input-shell">
            <button class="btn-primary">Save profile</button>
        </form>
    </div>
    <div class="glass-panel p-6">
        <h2 class="text-3xl font-bold heading-gradient">Change password</h2>
        <form action="{{ route('profile.password') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            @method('PUT')
            <input name="current_password" type="password" class="input-shell" placeholder="Current password">
            <input name="password" type="password" class="input-shell" placeholder="New password">
            <input name="password_confirmation" type="password" class="input-shell" placeholder="Confirm password">
            <button class="btn-primary">Update password</button>
        </form>
    </div>
</div>
@endsection

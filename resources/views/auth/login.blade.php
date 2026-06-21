@extends('layouts.auth')

@section('content')
<h1 class="text-3xl font-bold">Sign in</h1>
<p class="mt-2 text-sm text-slate-400">Access your dashboard and continue publishing.</p>

@if ($errors->any())
    <div class="mt-4 rounded-2xl border border-red-500/20 bg-red-500/10 p-4 text-sm text-red-400">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login.attempt') }}" class="mt-8 space-y-4">
    @csrf
    <input name="email" type="email" class="input-shell" placeholder="Email" value="{{ old('email') }}" required>
    <input name="password" type="password" class="input-shell" placeholder="Password" required>
    <label class="flex items-center gap-2 text-sm text-slate-400">
        <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}> Remember me
    </label>
    <button class="btn-primary w-full">Sign in</button>
</form>
<div class="mt-6 flex justify-between text-sm">
    <a href="{{ route('password.request') }}">Forgot password?</a>
    <a href="{{ route('register') }}">Create account</a>
</div>
@endsection

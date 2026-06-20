@extends('layouts.auth')

@section('content')
<h1 class="text-3xl font-bold">Sign in</h1>
<p class="mt-2 text-sm text-slate-400">Access your dashboard and continue publishing.</p>
<form method="POST" action="{{ route('login.attempt') }}" class="mt-8 space-y-4">
    @csrf
    <input name="email" type="email" class="input-shell" placeholder="Email">
    <input name="password" type="password" class="input-shell" placeholder="Password">
    <label class="flex items-center gap-2 text-sm text-slate-400"><input type="checkbox" name="remember"> Remember me</label>
    <button class="btn-primary w-full">Sign in</button>
</form>
<div class="mt-6 flex justify-between text-sm">
    <a href="{{ route('password.request') }}">Forgot password?</a>
    <a href="{{ route('register') }}">Create account</a>
</div>
@endsection

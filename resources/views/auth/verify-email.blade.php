@extends('layouts.auth')

@section('content')
<h1 class="text-3xl font-bold">Verify your email</h1>
<p class="mt-3 text-sm text-slate-400">We sent a verification link to your inbox.</p>
<form method="POST" action="{{ route('verification.send') }}" class="mt-8">
    @csrf
    <button class="btn-primary w-full">Resend verification email</button>
</form>
@endsection

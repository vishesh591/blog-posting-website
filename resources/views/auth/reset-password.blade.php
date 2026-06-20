@extends('layouts.auth')

@section('content')
<h1 class="text-3xl font-bold">Choose new password</h1>
<form method="POST" action="{{ route('password.update') }}" class="mt-8 space-y-4">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input name="email" type="email" value="{{ $email }}" class="input-shell" placeholder="Email">
    <input name="password" type="password" class="input-shell" placeholder="Password">
    <input name="password_confirmation" type="password" class="input-shell" placeholder="Confirm password">
    <button class="btn-primary w-full">Reset password</button>
</form>
@endsection

@extends('layouts.auth')

@section('content')
<h1 class="text-3xl font-bold">Reset password</h1>
<form method="POST" action="{{ route('password.email') }}" class="mt-8 space-y-4">
    @csrf
    <input name="email" type="email" class="input-shell" placeholder="Email">
    <button class="btn-primary w-full">Send reset link</button>
</form>
@endsection

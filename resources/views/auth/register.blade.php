@extends('layouts.auth')

@section('content')
<h1 class="text-3xl font-bold">Create account</h1>
<p class="mt-2 text-sm text-slate-400">Join as a reader or start as an author.</p>
<form method="POST" action="{{ route('register.store') }}" class="mt-8 space-y-4">
    @csrf
    <input name="name" class="input-shell" placeholder="Full name">
    <input name="email" type="email" class="input-shell" placeholder="Email">
    <select name="role" class="input-shell">
        <option value="author">Author</option>
        <option value="reader">Reader</option>
    </select>
    <input name="password" type="password" class="input-shell" placeholder="Password">
    <input name="password_confirmation" type="password" class="input-shell" placeholder="Confirm password">
    <button class="btn-primary w-full">Create account</button>
</form>
@endsection

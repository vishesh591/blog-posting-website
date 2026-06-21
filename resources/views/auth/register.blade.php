@extends('layouts.auth')

@section('content')
<h1 class="text-3xl font-bold">Create account</h1>
<p class="mt-2 text-sm text-slate-400">Join as a reader or start as an author.</p>

@if ($errors->any())
    <div class="mt-4 rounded-2xl border border-red-500/20 bg-red-500/10 p-4 text-sm text-red-400">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register.store') }}" class="mt-8 space-y-4">
    @csrf
    <input name="name" class="input-shell" placeholder="Full name" value="{{ old('name') }}" required>
    <input name="email" type="email" class="input-shell" placeholder="Email" value="{{ old('email') }}" required>
    <select name="role" class="input-shell">
        <option value="author" {{ old('role') === 'author' ? 'selected' : '' }}>Author</option>
        <option value="reader" {{ old('role') === 'reader' ? 'selected' : '' }}>Reader</option>
    </select>
    <input name="password" type="password" class="input-shell" placeholder="Password" required>
    <input name="password_confirmation" type="password" class="input-shell" placeholder="Confirm password" required>
    <button class="btn-primary w-full">Create account</button>
</form>
@endsection

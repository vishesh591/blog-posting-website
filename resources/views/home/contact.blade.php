@extends('layouts.app')

@section('content')
<section class="section-shell py-16">
    <div class="glass-panel mx-auto max-w-3xl p-8">
        <p class="eyebrow">Contact</p>
        <h1 class="mt-4 text-4xl font-bold">Talk to the team behind the publication.</h1>
        <form method="POST" action="{{ route('contact.send') }}" class="mt-8 space-y-4">
            @csrf
            <input name="name" class="input-shell" placeholder="Your name">
            <input name="email" class="input-shell" placeholder="Your email">
            <textarea name="message" rows="6" class="input-shell" placeholder="How can we help?"></textarea>
            <button class="btn-primary">Send message</button>
        </form>
    </div>
</section>
@endsection

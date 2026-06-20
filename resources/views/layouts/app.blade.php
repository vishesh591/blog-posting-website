<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'InkPress' }}</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body class="min-h-screen">
    <div class="fixed right-4 top-4 z-50 w-full max-w-sm" data-toast-root></div>
    @if (session('success'))
        <span data-flash="{{ session('success') }}" class="hidden"></span>
    @endif

    <header class="sticky top-0 z-40 border-b border-white/10 bg-slate-950/70 backdrop-blur-xl">
        <div class="section-shell flex items-center justify-between py-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3 text-lg font-bold">
                <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-500 text-white">IP</span>
                <span>InkPress</span>
            </a>
            <nav class="hidden items-center gap-6 text-sm text-slate-300 md:flex">
                <a href="{{ route('blogs.index') }}">Stories</a>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('contact') }}">Contact</a>
                <a href="{{ route('search.index') }}">Search</a>
            </nav>
            <div class="flex items-center gap-3">
                <button data-theme-toggle class="rounded-2xl border border-white/10 px-4 py-2 text-sm">Theme</button>
                @auth
                    <a href="{{ route('dashboard.index') }}" class="btn-secondary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-secondary">Sign in</a>
                    <a href="{{ route('register') }}" class="btn-primary">Get started</a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer class="mt-20 border-t border-white/10 py-10 text-sm text-slate-400">
        <div class="section-shell flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="font-semibold text-white">InkPress</p>
                <p>Production-ready publishing for modern editorial teams.</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('contact') }}">Contact</a>
                <a href="{{ route('blogs.index') }}">Blogs</a>
            </div>
        </div>
    </footer>
</body>
</html>

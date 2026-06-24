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
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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
                <button data-theme-toggle class="btn-theme-toggle" aria-label="Toggle theme">
                    <!-- Sun icon for dark mode -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sun-icon h-5 w-5">
                        <circle cx="12" cy="12" r="4"></circle>
                        <path d="M12 2v2"></path>
                        <path d="M12 20v2"></path>
                        <path d="m4.93 4.93 1.41 1.41"></path>
                        <path d="m17.66 17.66 1.41 1.41"></path>
                        <path d="M2 12h2"></path>
                        <path d="M20 12h2"></path>
                        <path d="m6.34 17.66-1.41 1.41"></path>
                        <path d="m19.07 4.93-1.41 1.41"></path>
                    </svg>
                    <!-- Moon icon for light mode -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="moon-icon h-5 w-5">
                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
                    </svg>
                </button>
                @auth
                    <a href="{{ route('dashboard.index') }}" class="hidden btn-secondary md:inline-flex">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="hidden btn-secondary md:inline-flex">Sign in</a>
                    <a href="{{ route('register') }}" class="hidden btn-primary md:inline-flex">Get started</a>
                @endauth
                <button id="mobile-menu-toggle" class="btn-theme-toggle md:hidden" aria-label="Open menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                        <line x1="4" x2="20" y1="12" y2="12"></line>
                        <line x1="4" x2="20" y1="6" y2="6"></line>
                        <line x1="4" x2="20" y1="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Mobile Dropdown Navigation Menu -->
        <div id="mobile-menu" class="hidden border-t border-white/10 bg-slate-950 px-4 py-4 space-y-2 md:hidden">
            <a href="{{ route('blogs.index') }}" class="block text-sm text-slate-300 hover:text-white py-2 transition-colors">Stories</a>
            <a href="{{ route('about') }}" class="block text-sm text-slate-300 hover:text-white py-2 transition-colors">About</a>
            <a href="{{ route('contact') }}" class="block text-sm text-slate-300 hover:text-white py-2 transition-colors">Contact</a>
            <a href="{{ route('search.index') }}" class="block text-sm text-slate-300 hover:text-white py-2 transition-colors">Search</a>
            <div class="border-t border-white/10 my-2"></div>
            @auth
                <a href="{{ route('dashboard.index') }}" class="block text-sm text-orange-400 hover:text-orange-300 py-2 font-semibold transition-colors">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="block text-sm text-slate-300 hover:text-white py-2 transition-colors">Sign in</a>
                <a href="{{ route('register') }}" class="block text-sm text-orange-400 hover:text-orange-300 py-2 font-semibold transition-colors">Get started</a>
            @endauth
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
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
        document.getElementById('mobile-menu-toggle')?.addEventListener('click', toggleMobileMenu);
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} | InkPress</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen">
    <div class="fixed right-4 top-4 z-50 w-full max-w-sm" data-toast-root></div>
    @if (session('success'))
        <span data-flash="{{ session('success') }}" class="hidden"></span>
    @endif

    <div class="flex min-h-screen">
        <aside class="hidden w-72 shrink-0 border-r border-white/10 bg-slate-950/70 p-6 backdrop-blur-xl lg:block">
            <a href="{{ route('dashboard.index') }}" class="mb-8 flex items-center gap-3 text-lg font-bold">
                <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-500 text-white">IP</span>
                <span>InkPress</span>
            </a>
            <div class="space-y-2 text-sm">
                <a href="{{ route('dashboard.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-white/10">Overview</a>
                @if (in_array(auth()->user()->role, ['admin', 'author']))
                    <a href="{{ route('dashboard.blogs.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-white/10">Blogs</a>
                    <a href="{{ route('dashboard.categories.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-white/10">Categories</a>
                    <a href="{{ route('dashboard.tags.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-white/10">Tags</a>
                    <a href="{{ route('dashboard.media.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-white/10">Media Library</a>
                @endif
                <a href="{{ route('profile.edit') }}" class="block rounded-2xl px-4 py-3 hover:bg-white/10">Profile</a>
                <a href="{{ route('dashboard.notifications') }}" class="block rounded-2xl px-4 py-3 hover:bg-white/10">Notifications</a>
            </div>
        </aside>
        <div class="flex-1">
            <header class="border-b border-white/10 bg-slate-950/70 px-4 py-4 backdrop-blur-xl sm:px-8">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-slate-400">Welcome back</p>
                        <h1 class="text-2xl font-bold">{{ auth()->user()->name }}</h1>
                    </div>
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
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn-secondary">Logout</button>
                        </form>
                    </div>
                </div>
            </header>
            <main class="p-4 sm:p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

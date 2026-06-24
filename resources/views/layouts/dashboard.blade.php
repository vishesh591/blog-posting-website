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

    <!-- Mobile Navigation Drawer Backdrop -->
    <div id="mobile-drawer-backdrop" class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm hidden lg:hidden" onclick="toggleMobileDrawer()"></div>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-drawer" class="fixed inset-y-0 left-0 z-50 w-72 transform -translate-x-full bg-slate-950/95 border-r border-white/10 p-6 transition-transform duration-300 ease-in-out lg:hidden flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-8">
                <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 text-lg font-bold">
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-500 text-white">IP</span>
                    <span>InkPress</span>
                </a>
                <button onclick="toggleMobileDrawer()" class="text-slate-400 hover:text-white" aria-label="Close menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                        <line x1="18" x2="6" y1="6" y2="18"></line>
                        <line x1="6" x2="18" y1="6" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="space-y-1.5 text-sm">
                <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 hover:bg-white/10 {{ request()->routeIs('dashboard.index') ? 'active-sidebar-link' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span>Overview</span>
                </a>
                @if (in_array(auth()->user()->role, ['admin', 'author']))
                    <a href="{{ route('dashboard.blogs.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 hover:bg-white/10 {{ request()->routeIs('dashboard.blogs.*') ? 'active-sidebar-link' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                        <span>Blogs</span>
                    </a>
                    <a href="{{ route('dashboard.categories.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 hover:bg-white/10 {{ request()->routeIs('dashboard.categories.*') ? 'active-sidebar-link' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 012.008 1.24l.885 1.77a2.25 2.25 0 002.007 1.24h1.98a2.25 2.25 0 002.007-1.24l.885-1.77a2.25 2.25 0 012.007-1.24h3.86m-18 0h18a2.25 2.25 0 012.25 2.25v6a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 21.75v-6a2.25 2.25 0 012.25-2.25zm0-4.5h16.5m-16.5-4.5h16.5" />
                        </svg>
                        <span>Categories</span>
                    </a>
                    <a href="{{ route('dashboard.tags.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 hover:bg-white/10 {{ request()->routeIs('dashboard.tags.*') ? 'active-sidebar-link' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                        </svg>
                        <span>Tags</span>
                    </a>
                    <a href="{{ route('dashboard.media.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 hover:bg-white/10 {{ request()->routeIs('dashboard.media.*') ? 'active-sidebar-link' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        <span>Media Library</span>
                    </a>
                @endif
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 hover:bg-white/10 {{ request()->routeIs('profile.edit') ? 'active-sidebar-link' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Profile</span>
                </a>
                <a href="{{ route('dashboard.notifications') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 hover:bg-white/10 {{ request()->routeIs('dashboard.notifications') ? 'active-sidebar-link' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    <span>Notifications</span>
                </a>
            </div>
        </div>
    </div>

    <div class="flex min-h-screen">
        <aside class="hidden w-72 shrink-0 border-r border-white/10 bg-slate-950/70 p-6 backdrop-blur-xl lg:block flex flex-col justify-between">
            <div>
                <a href="{{ route('dashboard.index') }}" class="mb-8 flex items-center gap-3 text-lg font-bold">
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-500 text-white">IP</span>
                    <span>InkPress</span>
                </a>
                <div class="space-y-1.5 text-sm">
                    <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 hover:bg-white/10 {{ request()->routeIs('dashboard.index') ? 'active-sidebar-link' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span>Overview</span>
                    </a>
                    @if (in_array(auth()->user()->role, ['admin', 'author']))
                        <a href="{{ route('dashboard.blogs.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 hover:bg-white/10 {{ request()->routeIs('dashboard.blogs.*') ? 'active-sidebar-link' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                            <span>Blogs</span>
                        </a>
                        <a href="{{ route('dashboard.categories.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 hover:bg-white/10 {{ request()->routeIs('dashboard.categories.*') ? 'active-sidebar-link' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 012.008 1.24l.885 1.77a2.25 2.25 0 002.007 1.24h1.98a2.25 2.25 0 002.007-1.24l.885-1.77a2.25 2.25 0 012.007-1.24h3.86m-18 0h18a2.25 2.25 0 012.25 2.25v6a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 21.75v-6a2.25 2.25 0 012.25-2.25zm0-4.5h16.5m-16.5-4.5h16.5" />
                            </svg>
                            <span>Categories</span>
                        </a>
                        <a href="{{ route('dashboard.tags.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 hover:bg-white/10 {{ request()->routeIs('dashboard.tags.*') ? 'active-sidebar-link' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                            </svg>
                            <span>Tags</span>
                        </a>
                        <a href="{{ route('dashboard.media.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 hover:bg-white/10 {{ request()->routeIs('dashboard.media.*') ? 'active-sidebar-link' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                            <span>Media Library</span>
                        </a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 hover:bg-white/10 {{ request()->routeIs('profile.edit') ? 'active-sidebar-link' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Profile</span>
                    </a>
                    <a href="{{ route('dashboard.notifications') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 hover:bg-white/10 {{ request()->routeIs('dashboard.notifications') ? 'active-sidebar-link' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        <span>Notifications</span>
                    </a>
                </div>
            </div>
        </aside>
        <div class="flex-1 min-w-0">
            <header class="border-b border-white/10 bg-slate-950/70 px-4 py-4 backdrop-blur-xl sm:px-8">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <button id="mobile-drawer-toggle" class="btn-theme-toggle lg:hidden" aria-label="Open navigation menu">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                                <line x1="4" x2="20" y1="12" y2="12"></line>
                                <line x1="4" x2="20" y1="6" y2="6"></line>
                                <line x1="4" x2="20" y1="18" y2="18"></line>
                            </svg>
                        </button>
                        <div>
                            <p class="text-sm text-slate-400">Welcome back</p>
                            <h1 class="text-2xl font-bold heading-gradient">{{ auth()->user()->name }}</h1>
                        </div>
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
            <main class="p-4 sm:p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleMobileDrawer() {
            const drawer = document.getElementById('mobile-drawer');
            const backdrop = document.getElementById('mobile-drawer-backdrop');
            drawer.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
        document.getElementById('mobile-drawer-toggle')?.addEventListener('click', toggleMobileDrawer);
    </script>
</body>
</html>

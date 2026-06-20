<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Auth' }} | InkPress</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen">
    <div class="section-shell flex min-h-screen items-center justify-center py-10">
        <div class="grid w-full max-w-6xl gap-8 lg:grid-cols-[1.2fr_0.8fr]">
            <div class="glass-panel reveal hidden p-10 lg:block">
                <span class="eyebrow">Editorial OS</span>
                <h1 class="mt-6 text-5xl font-bold">Build a publication your readers remember.</h1>
                <p class="mt-5 max-w-xl text-lg text-slate-300">A polished SaaS-style publishing stack with workflows, analytics, media tools, and collaborative author management.</p>
            </div>
            <div class="glass-panel p-8">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>

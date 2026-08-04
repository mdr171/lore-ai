<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Lore.AI - Xianxia Novel Lore & Character Extraction')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="navbar">
        <div class="container nav-content">
            <a href="{{ route('dashboard') }}" class="brand">
                <span class="brand-icon">🗡️</span> Lore.AI
            </a>
            <div class="nav-links">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('chapters.index') }}" class="{{ request()->routeIs('chapters.*') ? 'active' : '' }}">Chapters</a>
                <a href="{{ route('chapters.create') }}" class="btn btn-primary-sm">+ Analyze New Chapter</a>
            </div>
        </div>
    </div>

    <main class="container main-content">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        <div class="container text-center">
            <p>Lore.AI &copy; {{ date('Y') }} - Xianxia Lore & Character Extractor Powered by DeepSeek LLM</p>
        </div>
    </footer>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Recepción Virtual')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Mono:wght@400;500&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <script src="https://unpkg.com/konva@10/konva.min.js"></script>
</head>

<body class="bg-background text-on-surface">

<header>
    <div class="header-inner">
        <div class="header-brand">
            <div class="brand-icon">🎟</div>
            <div class="brand-text">Cal<span>cite</span></div>
            <div class="header-status">
                <div class="status-dot"></div>
                SISTEMA ACTIVO
            </div>
        </div>

        <nav>
            <a href="{{ route('catalog.index') }}">Eventos</a>
            <a href="{{ route('auth.logout') }}" class="btn-nav-logout">Cerrar Sesión</a>
        </nav>
    </div>
</header>

<div class="page-wrapper">
    <main class="flex-1 min-h-screen">
        @yield('content')
    </main>
</div>

<footer>
    <div class="footer-inner">
        <span>CALCITE</span>
        SISTEMA DE RECEPCIÓN VIRTUAL
        ·
        ASESORES RECEPCIONISTAS
        ·
        {{ date('Y') }}
    </div>
</footer>

@stack('scripts')
</body>
</html>

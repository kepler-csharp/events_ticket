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

    <link rel="stylesheet" href="/css/app.css">

    <style>
        /* ─── RESET & BASE ───────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --or:        #FD7B41;   /* naranja primario */
            --or-dim:    #b84e1f;   /* naranja apagado */
            --or-glow:   rgba(253, 123, 65, 0.18);
            --or-glow-s: rgba(253, 123, 65, 0.08);
            --tan:       #EDBF9B;   /* terracota/secundario */
            --ink:       #3C4044;   /* gris carbón */
            --ash:       #DDDCDB;   /* gris claro */

            --bg:        #0d0e10;
            --bg-panel:  #12141a;
            --bg-card:   #161920;
            --bg-card2:  #1c1f28;
            --line:      rgba(255,255,255,0.06);
            --line-or:   rgba(253,123,65,0.25);

            --txt:       #e8e6e3;
            --txt-dim:   #7a7f8a;
            --txt-faint: #3d4150;

            --font-head: 'Syne', sans-serif;
            --font-body: 'Outfit', sans-serif;
            --font-mono: 'DM Mono', monospace;

            --r-sm: 6px;
            --r-md: 10px;
            --r-lg: 16px;

            --t: 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-body);
            background: var(--bg);
            color: var(--txt);
            min-height: 100vh;
            font-size: 15px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* scanline texture overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(0,0,0,0.04) 2px,
                rgba(0,0,0,0.04) 4px
            );
            pointer-events: none;
            z-index: 9999;
        }

        /* ─── HEADER ─────────────────────────────────────────────────── */
        header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(13,14,16,0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--line);
        }

        header::after {
            content: '';
            display: block;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--or), transparent);
            opacity: 0.4;
        }

        .header-inner {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 2rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 34px;
            height: 34px;
            background: var(--or);
            border-radius: 8px;
            display: grid;
            place-items: center;
            font-size: 16px;
            flex-shrink: 0;
            box-shadow: 0 0 16px var(--or-glow);
        }

        .brand-text {
            font-family: var(--font-head);
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--txt);
        }

        .brand-text span {
            color: var(--or);
        }

        .header-status {
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: var(--font-mono);
            font-size: 0.7rem;
            color: var(--txt-dim);
            letter-spacing: 0.08em;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #4ade80;
            box-shadow: 0 0 8px #4ade80;
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        header nav {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        header nav a {
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--txt-dim);
            text-decoration: none;
            padding: 0.45rem 0.85rem;
            border-radius: var(--r-sm);
            transition: var(--t);
            letter-spacing: 0.01em;
        }

        header nav a:hover {
            color: var(--txt);
            background: var(--line);
        }

        .btn-nav-logout {
            background: none;
            border: 1px solid var(--line-or);
            color: var(--or) !important;
            cursor: pointer;
            font-family: var(--font-body);
            font-size: 0.82rem;
            font-weight: 600;
            padding: 0.4rem 0.9rem;
            border-radius: var(--r-sm);
            transition: var(--t);
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .btn-nav-logout:hover {
            background: var(--or-glow-s) !important;
            box-shadow: 0 0 12px var(--or-glow);
        }

        /* ─── LAYOUT ─────────────────────────────────────────────────── */
        .page-wrapper {
            max-width: 1440px;
            margin: 0 auto;
            padding: 2.5rem 2rem 4rem;
        }

        main { min-height: calc(100vh - 64px - 80px); }

        /* ─── FOOTER ─────────────────────────────────────────────────── */
        footer {
            border-top: 1px solid var(--line);
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .footer-inner {
            font-family: var(--font-mono);
            font-size: 0.7rem;
            color: var(--txt-faint);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .footer-inner span { color: var(--or); }

        /* ─── GLOBAL COMPONENTS ──────────────────────────────────────── */

        /* Page heading */
        .page-heading {
            margin-bottom: 2.5rem;
        }

        .page-heading .eyebrow {
            font-family: var(--font-mono);
            font-size: 0.7rem;
            color: var(--or);
            letter-spacing: 0.2em;
            text-transform: uppercase;
            margin-bottom: 0.6rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .page-heading .eyebrow::before {
            content: '';
            display: inline-block;
            width: 20px;
            height: 1px;
            background: var(--or);
        }

        .page-heading h1, .page-heading h2 {
            font-family: var(--font-head);
            font-size: clamp(2rem, 4vw, 3.2rem);
            font-weight: 800;
            line-height: 1.05;
            letter-spacing: -0.03em;
            color: var(--txt);
        }

        .page-heading h1 em, .page-heading h2 em {
            font-style: normal;
            color: var(--or);
        }

        .page-heading p {
            margin-top: 0.75rem;
            color: var(--txt-dim);
            font-size: 0.95rem;
            max-width: 560px;
        }

        /* Panel / card */
        .panel {
            background: var(--bg-panel);
            border: 1px solid var(--line);
            border-radius: var(--r-lg);
            padding: 1.75rem;
        }

        .panel-title {
            font-family: var(--font-mono);
            font-size: 0.7rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--txt-dim);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .panel-title::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 2px;
            background: var(--or);
            flex-shrink: 0;
        }

        /* Inputs */
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            background: var(--bg-card);
            border: 1px solid var(--line);
            border-radius: var(--r-md);
            color: var(--txt);
            font-family: var(--font-body);
            font-size: 0.95rem;
            padding: 0.8rem 1rem;
            transition: var(--t);
            outline: none;
        }

        input[type="text"]::placeholder,
        input[type="email"]::placeholder,
        input[type="password"]::placeholder {
            color: var(--txt-faint);
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: var(--or);
            box-shadow: 0 0 0 3px var(--or-glow-s), 0 0 20px var(--or-glow);
        }

        label {
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--txt-dim);
            font-family: var(--font-mono);
        }

        /* Primary button */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--or);
            color: #0d0e10;
            font-family: var(--font-body);
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 0.03em;
            border: none;
            border-radius: var(--r-md);
            padding: 0.8rem 1.6rem;
            cursor: pointer;
            transition: var(--t);
            text-decoration: none;
        }

        .btn-primary:hover {
            background: #ff8c52;
            box-shadow: 0 0 24px var(--or-glow), 0 4px 16px rgba(253,123,65,0.3);
            transform: translateY(-1px);
        }

        .btn-primary:active { transform: translateY(0); }

        /* Ghost button */
        .btn-ghost {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: transparent;
            color: var(--txt-dim);
            font-family: var(--font-body);
            font-weight: 500;
            font-size: 0.9rem;
            border: 1px solid var(--line);
            border-radius: var(--r-md);
            padding: 0.8rem 1.6rem;
            cursor: pointer;
            transition: var(--t);
            text-decoration: none;
        }

        .btn-ghost:hover {
            border-color: rgba(255,255,255,0.15);
            color: var(--txt);
            background: var(--line);
        }

        /* Error alert */
        .alert-error {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.3);
            color: #fca5a5;
            border-radius: var(--r-md);
            padding: 0.9rem 1.1rem;
            font-size: 0.88rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-error::before { content: '⚠'; font-size: 1rem; }

        /* Field error */
        .field-error {
            color: #f87171;
            font-size: 0.78rem;
            margin-top: 0.35rem;
            font-family: var(--font-mono);
        }

        /* Divider line */
        .divider {
            height: 1px;
            background: var(--line);
            margin: 2rem 0;
        }

        /* Back link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--txt-dim);
            text-decoration: none;
            font-size: 0.83rem;
            font-weight: 500;
            letter-spacing: 0.04em;
            margin-bottom: 2rem;
            transition: var(--t);
            font-family: var(--font-mono);
        }

        .back-link:hover { color: var(--or); }

        .back-link svg { transition: transform var(--t); }
        .back-link:hover svg { transform: translateX(-3px); }

        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-family: var(--font-mono);
            font-size: 0.68rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.28rem 0.7rem;
            border-radius: 4px;
        }

        .badge-or {
            background: var(--or-glow);
            color: var(--or);
            border: 1px solid var(--line-or);
        }

        .badge-green {
            background: rgba(74,222,128,0.08);
            color: #4ade80;
            border: 1px solid rgba(74,222,128,0.2);
        }

        .badge-red {
            background: rgba(239,68,68,0.08);
            color: #f87171;
            border: 1px solid rgba(239,68,68,0.2);
        }

        .badge-dim {
            background: rgba(255,255,255,0.04);
            color: var(--txt-dim);
            border: 1px solid var(--line);
        }

        /* Corner decoration */
        .corner-decor {
            position: relative;
        }
        .corner-decor::before,
        .corner-decor::after {
            content: '';
            position: absolute;
            width: 12px;
            height: 12px;
            border-color: var(--or);
            border-style: solid;
            opacity: 0.5;
        }
        .corner-decor::before {
            top: -1px; left: -1px;
            border-width: 2px 0 0 2px;
            border-radius: 3px 0 0 0;
        }
        .corner-decor::after {
            bottom: -1px; right: -1px;
            border-width: 0 2px 2px 0;
            border-radius: 0 0 3px 0;
        }
    </style>
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

        @auth
            <nav>
                <a href="{{ route('catalog') }}">Eventos</a>
                <form action="{{ route('auth.logout') }}" method="post" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-nav-logout">Salir</button>
                </form>
            </nav>
        @endauth
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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Recepción Virtual')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <link rel="stylesheet" href="/css/app.css">
</head>

<body class="bg-background text-on-surface">

    <header>
        <h1>Hello to Advisers Ticket Page</h1>
    </header>

    <div class="flex pt-16">
        <main class="flex-1 min-h-screen">
            @yield('content')
        </main>
    </div>

    <footer>
        Thanks for visiting us
    </footer>

</body>
</html>

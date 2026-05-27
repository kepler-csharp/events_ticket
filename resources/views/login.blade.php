<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicia Sesión</title>

    @vite([
        'resources/css/login.css'
    ])
</head>
<body>
<div class="login-wrapper">
    <div class="login-container">
        <div class="login-header">
            <div class="logo">🎟️</div>
            <h1>Calcite</h1>
            <p>Sistema de Recepción Virtual</p>
        </div>

        @error('failedReq')
            <div class="error">
                <strong>⚠️ Error de Autenticación</strong>
                {{ $message }}
            </div>
        @enderror

        <form action="{{ route('auth.login') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="email">📧 Correo Electrónico</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="asesor@ejemplo.com"
                    required
                    value="{{ old('email') }}"
                >
            </div>

            <div class="form-group">
                <label for="password">🔒 Contraseña</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Ingresa tu contraseña"
                    required
                >
            </div>

            <button type="submit" class="login-button">
                🚀 Iniciar Sesión
            </button>

            <div class="security-info">
                <span class="material-symbols-outlined">lock</span>
                Tu información está protegida y encriptada
            </div>
        </form>
    </div>
</div>
</body>
</html>

<!--
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <div class="logo">🎟️</div>
                <h1>Calcite</h1>
                <p>Sistema de Recepción Virtual</p>
            </div>


            <div class="error">
                <strong>⚠️ Error de Autenticación</strong>

            </div>


            <form action="" method="post">


                <div class="form-group">
                    <label for="email">📧 Correo Electrónico</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="asesor@ejemplo.com"
                        required
                        value=""
                    >
                </div>

                <div class="form-group">
                    <label for="password">🔒 Contraseña</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Ingresa tu contraseña"
                        required
                    >
                </div>

                <button type="submit" class="login-button">
                    🚀 Iniciar Sesión
                </button>

                <div class="security-info">
                    <span class="material-symbols-outlined">lock</span>
                    Tu información está protegida y encriptada
                </div>
            </form>

            <div class="divider">
                <span>¿Nuevo usuario?</span>
            </div>

            <div class="register-link">
                <p>¿No tienes cuenta aún?</p>
                <a href="">Crea una cuenta aquí</a>
            </div>
        </div>
    </div>

-->

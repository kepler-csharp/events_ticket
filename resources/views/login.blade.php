@extends('layouts.app')
@section("title", "Iniciar Sesión")

@section("content")
    <style>
        body {
            background: linear-gradient(135deg, var(--color-primary) 0%, #ff8c5a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-family);
        }

        .login-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 300px);
            padding: 2rem;
        }

        .login-container {
            background: rgba(255,255,255,.96);
            padding: 3rem;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 450px;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-header .logo {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .login-header h1 {
            font-size: 2rem;
            color: var(--color-dark);
            margin-bottom: 0.5rem;
            font-weight: 800;
        }

        .login-header p {
            color: #999;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: var(--color-dark);
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.95rem 1.1rem;
            border: 2px solid var(--color-light);
            border-radius: 10px;
            font-family: var(--font-family);
            font-size: 0.95rem;
            transition: var(--transition);
            background: #f9f9f9;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--color-primary);
            background: rgba(255,255,255,.96);
            box-shadow: 0 0 0 4px rgba(253, 123, 65, 0.1);
        }

        .form-group input::placeholder {
            color: #ccc;
        }

        .login-button {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--color-primary) 0%, #ff8c5a 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            margin-bottom: 1rem;
            font-family: var(--font-family);
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(253, 123, 65, 0.3);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .error {
            background: #ffebee;
            border: 2px solid #f44336;
            color: #c62828;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .error strong {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .divider {
            text-align: center;
            margin: 2rem 0;
            position: relative;
            color: #999;
            font-size: 0.9rem;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--color-light);
            z-index: 0;
        }

        .divider span {
            background: rgba(255,255,255,.96);
            padding: 0 1rem;
            position: relative;
            z-index: 1;
        }

        .register-link {
            text-align: center;
            color: #666;
            font-size: 0.95rem;
        }

        .register-link a {
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s;
        }

        .register-link a:hover {
            color: #ff6f2a;
        }

        .security-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: #f0f7ff;
            padding: 0.875rem;
            border-radius: 8px;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: #0066cc;
        }

        .security-info .material-symbols-outlined {
            font-size: 1.2rem;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 2rem;
            }

            .login-header h1 {
                font-size: 1.5rem;
            }

            .login-header .logo {
                font-size: 2.5rem;
            }
        }
    </style>

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

            <div class="divider">
                <span>¿Nuevo usuario?</span>
            </div>

            <div class="register-link">
                <p>¿No tienes cuenta aún?</p>
                <a href="{{ route('auth.register.form') }}">Crea una cuenta aquí</a>
            </div>
        </div>
    </div>

@endsection

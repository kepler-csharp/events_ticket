@extends('layouts.app')
@section('title', 'Creando Asesor')
@section('content')
    <div class="create-adviser-page">

        <div class="create-adviser-header">
            <div class="create-adviser-eyebrow">Administración</div>
            <h1 class="create-adviser-title">Crear <span>Asesor</span></h1>
        </div>

        @error('failedReq')
        <div class="alert alert--error">
            <span class="alert-icon">⚠️</span>
            {{ $message }}
        </div>
        @enderror

        <div class="create-adviser-panel">
            <div class="create-adviser-panel-title">👤 Datos del Nuevo Asesor</div>

            <form action="{{ route('advisers.store') }}" method="post">
                @csrf

                <div class="create-adviser-form-group">
                    @error('fullName')
                    <span class="create-adviser-field-error">{{ $message }}</span>
                    @enderror
                    <label class="create-adviser-label" for="fullName">Nombre Completo</label>
                    <input
                        class="create-adviser-input"
                        type="text"
                        id="fullName"
                        name="fullName"
                        placeholder="Ej: Juan García"
                        required
                        value="{{ old('fullName') }}"
                    >
                </div>

                <div class="create-adviser-form-group">
                    @error('email')
                    <span class="create-adviser-field-error">{{ $message }}</span>
                    @enderror
                    <label class="create-adviser-label" for="email">Correo Electrónico</label>
                    <input
                        class="create-adviser-input"
                        type="email"
                        id="email"
                        name="email"
                        placeholder="asesor@ejemplo.com"
                        required
                        value="{{ old('email') }}"
                    >
                </div>

                <div class="create-adviser-form-group">
                    @error('password')
                    <span class="create-adviser-field-error">{{ $message }}</span>
                    @enderror
                    <label class="create-adviser-label" for="password">Contraseña</label>
                    <input
                        class="create-adviser-input"
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Mínimo 8 caracteres"
                        required
                    >
                </div>

                <div class="create-adviser-actions">
                    <button type="submit" class="btn-primary create-adviser-btn">
                        ✓ Crear Asesor
                    </button>
                    <a href="{{ route('advisers.index') }}" class="btn-ghost create-adviser-btn">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>

    </div>
@endsection

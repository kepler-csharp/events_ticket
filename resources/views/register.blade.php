@extends('layouts.app')
@section("title", "Register")

@section("content")
    <h1>REGISTRATE</h1>

    @error("failedReq")
        <p>{{ $message }}</p>
    @enderror

    <form action="{{ route('auth.register') }}" method="post">
        @csrf

        @error('fullName')
            <p>{{ $message }}</p>
        @enderror
        <label for="fullName">Nombre Completo</label>
        <input type="text" id="fullName" name="fullName" value="{{ old("fullName") }}" required >

        @error('email')
            <p>{{ $message }}</p>
        @enderror
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old("email") }}" required >

        @error('password')
            <p>{{ $message }}</p>
        @enderror
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required >

        <button type="submit">Iniciar sesión</button>
    </form>
@endsection

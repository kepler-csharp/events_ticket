@extends('layouts.app')
@section("title", "Register")

@section("content")
    <h1>REGISTRATE</h1>

    <form action="{{ route('auth.register') }}">
        @csrf

        <label for="fullname">Nombre Completo</label>
        <input type="text" id="fullname" name="fullname" required >

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required >

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required >

        <button type="submit">Iniciar sesión</button>
    </form>
@endsection

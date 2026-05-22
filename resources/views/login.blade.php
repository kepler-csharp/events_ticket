@extends('layouts.app')
@section("title", "Login")

@section("content")
    <h1>LOGUEAATE</h1>

    @if($errors->has("message"))
        <p>{{ $errors->first("message") }}</p>
    @endif


    <form action="{{ route('auth.login') }}" method="post">
        @csrf

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required >

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required >

        <button type="submit">Iniciar sesión</button>
    </form>
@endsection

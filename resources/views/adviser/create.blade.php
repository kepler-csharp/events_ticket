@extends('layouts.app')

@section('title', 'Creando Asesor')

@section('content')
    <!-- Displaying Errors -->
    @error('failedReq')
        <p>{{$message}}</p>
    @enderror

    <h1>Creando un asesor nuevo</h1>
    <form action="{{ route('adviser.store') }}" method="post">
        @csrf

        @error('fullname')
            <p>{{$messsage}}</p>
        @enderror
        <label for="fullname">Nombre Completo</label>
        <input type="text" name="fullname" required value="{{ old("fullname") }}">

        @error('email')
            <p>{{$message}}</p>
        @enderror
        <label for="email">Email</label>
        <input type="email" name="email" value="{{ old("email") }}" required>

        <label for="password">Contraseña</label>
        <input type="password" name="password" required>

        <button type="submit">Crear</button>
    </form>
@endsection

@extends('layouts.app')

@section("title", "Landing Page")

@section("content")
    <a href="{{ route('auth.login') }}">Login</a>
    <a href="{{ route('auth.register') }}">Register</a>
@endsection

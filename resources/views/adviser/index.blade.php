@extends('layouts.app')

@section('title', 'Panel de Asesores')

@section('content')
    <!-- Create Button -->
    <a href="{{ route('advisers.new') }}">Create new Adviser</a>

    <!-- Displaying advisers -->
    <h1>Advisers</h1>
    <table>
        <thead>
        <tr>
            <td>Full Name</td>
            <td>Email</td>
        </tr>
        </thead>
        <tbody>
        @forelse($advisers as $adviser)
            <tr>
                <td>{{$adviser['fullName']}}</td>
                <td>{{$adviser['email']}}</td>
            </tr>
        @empty
            <p>You must be logged as admin for watch this information</p>
        @endforelse
        </tbody>
    </table>
@endsection

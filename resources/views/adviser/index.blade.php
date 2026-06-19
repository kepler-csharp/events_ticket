@extends('layouts.app')
@section('title', 'Panel de Asesores')
@section('content')
    <div class="advisers-page">

        {{-- Errors --}}
        @error('failedReq')
        <div class="alert alert--error">
            <span class="alert-icon">⚠️</span>
            {{ $message }}
        </div>
        @enderror

        {{-- Success --}}
        @if(session('success'))
            <div class="order-success">
                <span>✓</span>
                {{ session('success') }}
            </div>
        @endif

        <div class="advisers-page-header">
            <div>
                <div class="advisers-eyebrow">Administración</div>
                <h1 class="advisers-title">Panel de <span>Asesores</span></h1>
            </div>
            <a href="{{ route('advisers.new') }}" class="btn-primary advisers-btn-new">
                + Nuevo Asesor
            </a>
        </div>

        <div class="advisers-panel">
            <div class="advisers-panel-title">👥 Asesores Registrados</div>

            <div class="advisers-table-wrap">
                <table class="advisers-table">
                    <thead>
                    <tr>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($advisers as $adviser)
                        <tr>
                            <td>{{ $adviser['fullName'] }}</td>
                            <td>
                                <span class="advisers-email">{{ $adviser['email'] }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">
                                <div class="advisers-empty">
                                    <span>🔒</span>
                                    Debes estar autenticado como administrador para ver esta información
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

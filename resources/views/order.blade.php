@extends("layouts.app")
@section('title', 'Confirmacion de Orden')

@section('content')
    <div class="order-page">

        {{-- Errors --}}
        @error('failedReq')
        <div class="order-error">
            <span>⚠️</span>
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

        <!-- Showtime Info -->
        <p>{{ $showtime['eventName'] }}</p>
        <p>Hora de inicio: {{ $showtime['startTime'] }}</p>
        <p>Hora de fin: {{ $showtime['endTime'] }}</p>
        <p>Price of each ticket: {{ $showtime['basePrice'] }}</p>

        <!-- Total Price -->
        <p>{{$totalPrice}}</p>

        <!-- Controls -->
        <a href="{{ route("order.confirm", request()->route("id")) }}">Confirmar pago</a>
        <a href="{{ route("order.cancel", request()->route("id")) }}">Cancelar orden</a>

    </div>
@endsection

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

        <!-- Showtime Info -->
        <p>{{ $showtime['eventName'] }}</p>
        <p>Hora de inicio: {{ $showtime['startTime'] }}</p>
        <p>Hora de fin: {{ $showtime['endTime'] }}</p>
        <p>Price of each ticket: {{ $showtime['basePrice'] }}</p>

        <!-- Total Price -->
        <h2>Total to pay:</h2>
        <p>{{$totalPrice}}</p>

        <!-- Controls -->
        <form action="{{ route('order.confirm', request()->route("id")) }}" method="post">
            <label for="payMethod">Método de Pago</label>
            <select name="payMethod" required>
                <option value="" disabled selected>Selecciona una opcion</option>
                <option value="cash">Efectivo</option>
                <option value="transfer">Transferencia</option>
                <option value="debitCard">Tarjeta de Débito</option>
                <option value="creditCard">Tarjeta de Cŕedito</option>
            </select>

            <button type="submit">Confirmar Pago</button>
        </form>

        <a href="{{ route("order.cancel", request()->route("id")) }}">Cancelar orden</a>
    </div>
@endsection

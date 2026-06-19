@extends("layouts.app")
@section('title', 'Confirmacion de Orden')
@section('content')
    <div class="payment-page">

        {{-- Error --}}
        @error('failedReq')
        <div class="order-error">
            <span>⚠️</span>
            {{ $message }}
        </div>
        @enderror

        {{-- Heading --}}
        <div class="payment-page-header">
            <div class="payment-eyebrow">Confirmación de Pago</div>
            <h1 class="payment-title">Resumen de tu <span>Orden</span></h1>
        </div>

        <div class="payment-layout">

            {{-- Showtime info --}}
            <div class="payment-panel">
                <div class="payment-panel-title">🎭 Detalles del Evento</div>

                <div class="payment-info-item">
                    <span class="payment-info-label">Evento</span>
                    <span class="payment-info-value payment-event-name">{{ $showtime['eventName'] }}</span>
                </div>

                <div class="payment-info-row">
                    <div class="payment-info-item">
                        <span class="payment-info-label">Hora de Inicio</span>
                        <span class="payment-info-value">
                        <span class="payment-time-badge">{{ $showtime['startTime'] }}</span>
                    </span>
                    </div>
                    <div class="payment-info-item">
                        <span class="payment-info-label">Hora de Fin</span>
                        <span class="payment-info-value">
                        <span class="payment-time-badge">{{ $showtime['endTime'] }}</span>
                    </span>
                    </div>
                </div>

                <div class="payment-info-item">
                    <span class="payment-info-label">Precio por Ticket</span>
                    <span class="payment-info-value payment-unit-price">{{ $showtime['basePrice'] }}</span>
                </div>

                {{-- Total --}}
                <div class="payment-total-block">
                    <span class="payment-total-label">Total a Pagar</span>
                    <span class="payment-total-amount">{{ $totalPrice }}</span>
                </div>
            </div>

            {{-- Payment form --}}
            <div class="payment-panel payment-form-panel">
                <div class="payment-panel-title">💳 Método de Pago</div>

                <form action="{{ route('order.confirm', request()->route('id')) }}" method="post">
                    @csrf
                    <div class="payment-form-group">
                        <label class="payment-label" for="payMethod">Selecciona cómo pagar</label>
                        <div class="payment-select-wrap">
                            <select name="payMethod" id="payMethod" class="payment-select" required>
                                <option value="" disabled selected>Selecciona una opción</option>
                                <option value="cash">💵 Efectivo</option>
                                <option value="transfer">🏦 Transferencia</option>
                                <option value="debitCard">💳 Tarjeta de Débito</option>
                                <option value="creditCard">💳 Tarjeta de Crédito</option>
                            </select>
                            <span class="payment-select-arrow">▾</span>
                        </div>
                    </div>

                    <div class="payment-actions">
                        <button type="submit" class="btn-primary payment-btn">
                            ✓ Confirmar Pago
                        </button>
                        <a href="{{ route('order.cancel', request()->route('id')) }}" class="btn-ghost payment-btn">
                            Cancelar Orden
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

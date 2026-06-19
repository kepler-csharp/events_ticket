
@extends('layouts.app')
@section('title', 'Seleccionar Asientos')

@section('content')
    <a href="javascript:history.back()" class="back-link">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
            <path d="M9 2L4 7L9 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        Volver
    </a>

    {{-- Errors --}}
    @error('failedReq')
    <div class="alert-error">
        <span>⚠️</span>
        {{ $message }}
    </div>
    @enderror

    <div class="seats-layout">
        <!-- Seats Selection -->
        <div class="seats-container">
            <h2 class="seats-container-title">🎟️ Selecciona tus Asientos</h2>

            <div class="seats-legend">
                <div class="legend-item">
                    <div class="legend-seat available"></div>
                    <span>Disponible</span>
                </div>
                <div class="legend-item">
                    <div class="legend-seat occupied"></div>
                    <span>Ocupado</span>
                </div>
                <div class="legend-item">
                    <div class="legend-seat selected"></div>
                    <span>Seleccionado</span>
                </div>
            </div>

            <!-- Displaying of seats with JS -->
            <div id="seat-map"></div>
        </div>

        <!-- Showtime Info & Purchase -->
        <div class="showtime-info">
            <div class="selected-seats-display">
                <p>Asientos Seleccionados:</p>
                <div class="seats-list" id="selectedSeatsDisplay">Ninguno</div>
            </div>

            <div class="total-price">
                <div class="label">Total a Pagar</div>
                <div class="amount" id="totalPrice">$0.00</div>
            </div>

            <form action="{{ route('event.buy-seats', request()->route('id')) }}" method="post" class="form-actions">
                @csrf
                <h2 class="seats-container-title">Usuario</h2>

                @error('email')
                    <span class="alert-error">{{ $message }}</span>
                @enderror
                <input type="email" placeholder="user@example.com" name="email" value="{{ old("email") }}" required>

                <div class="label">-> Si el usuario no está registrado</div>

                @error('fullname')
                <span class="alert-error">{{ $message }}</span>
                @enderror
                <input type="text" placeholder="Abraham Martinez" name="fullname" value="{{ old("fullname") }}">

                @error('phone')
                <span class="alert-error">{{ $message }}</span>
                @enderror
                <input type="text" placeholder="3092374321" name="phone" value="{{ old("phone") }}">

                <input type="hidden" name="seats" id="seatsInput" />

                <button type="submit" class="btn-primary" id="submitBtn">🎫 Registrar Compra</button>
                <a href="{{ route('catalog.index') }}" class="btn-ghost" style="text-align: center; text-decoration: none; ">Cancelar</a>
            </form>

            <div class="showtime-info-title" style="margin-top: 2rem;">Resumen de Función</div>

            <div class="info-item">
                <div class="info-label">📅 Fecha</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($showtime['startTime'])->format('d/m/Y') }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">⏰ Hora de Inicio</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($showtime['startTime'])->format('H:i') }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">🏁 Hora de Fin</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($showtime['endTime'])->format('H:i') }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">💵 Precio por Ticket</div>
                <div class="info-value price">${{ number_format($showtime['basePrice'], 2) }}</div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Passing vars to javascript and converting them as a safe way
            window.seats = @js($seats);
            window.showtime = @js($showtime);
        </script>
    @endpush

@endsection

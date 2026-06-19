@extends('layouts.app')
@section('title', 'Ticket View')
@section('content')
    <div class="ticket-page">

        {{-- Error --}}
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

        {{-- Heading --}}
        <div class="ticket-page-header">
            <div class="ticket-eyebrow">Comprobante de Pago</div>
            <h1 class="ticket-title">Orden <span>#{{ $order['orderId'] }}</span></h1>
        </div>

        <div class="ticket-layout">

            {{-- Main: tickets table --}}
            <div class="ticket-main">
                <div class="ticket-panel">
                    <div class="ticket-panel-title">🎟️ Tickets Generados</div>

                    <div class="ticket-table-wrap">
                        <table class="ticket-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Asiento</th>
                                <th>Evento</th>
                                <th>Hora de Inicio</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['tickets'] as $ticket)
                                <tr>
                                    <td><span class="ticket-badge">#{{ $ticket['ticketId'] }}</span></td>
                                    <td><span class="ticket-seat">{{ $ticket['seatLabel'] }}</span></td>
                                    <td>{{ $ticket['eventName'] }}</td>
                                    <td><span class="ticket-time">{{ \Carbon\Carbon::parse($ticket['showtimeStart'])->format('d/m/Y H:i') }}</span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="ticket-resend-wrap">
                        <a href="{{ route('bill.resend') }}" class="btn-ghost ticket-btn">
                            ✉️ Reenviar Email
                        </a>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <aside class="ticket-sidebar">

                {{-- Order meta --}}
                <div class="ticket-panel">
                    <div class="ticket-panel-title">Detalle de la Orden</div>

                    <div class="ticket-info-item">
                        <span class="ticket-info-label">Método de Pago</span>
                        <span class="ticket-info-value">
                            @switch($order['paymentMethod'])
                                @case("cash")
                                    Efectivo 💵
                                    @break
                                @case("transfer")
                                    Transferencia 🏦
                                    @break
                                @case("debitCard")
                                    Tarjeta de Débito 💳
                                    @break
                                @case("creditCard")
                                    Tarjeta de Crédito 💳
                                    @break
                            @endswitch
                        </span>
                    </div>

                    <div class="ticket-info-item">
                        <span class="ticket-info-label">Pagado el</span>
                        <span class="ticket-info-value">{{ \Carbon\Carbon::parse($order['paidAt'])->format('d/m/Y H:i') }}</span>
                    </div>

                    <div class="ticket-total-block">
                        <span class="ticket-total-label">Total Pagado</span>
                        <span class="ticket-total-amount">{{ $order['amountPaid'] }}$</span>
                    </div>
                </div>

                {{-- Customer --}}
                <div class="ticket-panel">
                    <div class="ticket-panel-title">👤 Cliente</div>

                    <div class="ticket-info-item">
                        <span class="ticket-info-label">Nombre</span>
                        <span class="ticket-info-value">{{ $order['customerName'] }}</span>
                    </div>

                    <div class="ticket-info-item" style="border-bottom: none;">
                        <span class="ticket-info-label">Email</span>
                        <span class="ticket-info-value">{{ $order['customerEmail'] }}</span>
                    </div>
                </div>

            </aside>
        </div>

    </div>
@endsection

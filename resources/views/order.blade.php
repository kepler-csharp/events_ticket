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

        {{-- Page heading --}}
        <div class="order-page-header">
            <div class="order-page-eyebrow">Confirmación de Orden</div>
            <h1 class="order-page-title">Orden <span class="order-id">#{{ $order['id'] }}</span></h1>
        </div>

        <div class="order-layout">

            {{-- Main column --}}
            <div class="order-main">

                {{-- Tickets table --}}
                <div class="order-panel">
                    <div class="order-panel-title">
                        🎟️ Tickets a Comprar
                    </div>

                    <div class="order-table-wrap">
                        <table class="order-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Asiento</th>
                                <th>Evento</th>
                                <th>Hora de Inicio</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['items'] as $item)
                                <tr>
                                    <td>
                                        <span class="order-badge">#{{ $item['id'] }}</span>
                                    </td>
                                    <td>
                                        <span class="seat-label">{{ $item['seatLabel'] }}</span>
                                    </td>
                                    <td>{{ $item['eventName'] }}</td>
                                    <td>
                                        <span class="order-time">{{ $item['showtimeStart'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <aside class="order-sidebar">

                {{-- Order meta --}}
                <div class="order-panel">
                    <div class="order-panel-title">Detalle de Orden</div>

                    <div class="order-info-item">
                        <span class="order-info-label">Email</span>
                        <span class="order-info-value">{{ $order['userEmail'] }}</span>
                    </div>

                    <div class="order-info-item">
                        <span class="order-info-label">Generada el</span>
                        <span class="order-info-value">{{ $order['createdAt'] }}</span>
                    </div>

                    <div class="order-info-item">
                        <span class="order-info-label">Estado</span>
                        @if($order['status'] == 0)
                            <span class="order-status order-status--pending">● Pendiente</span>
                        @elseif($order['status'] == 1)
                            <span class="order-status order-status--completed">● Completada</span>
                        @elseif($order['status'] == 2)
                            <span class="order-status order-status--cancelled">● Cancelada</span>
                        @endif
                    </div>

                    {{-- Total --}}
                    <div class="order-total-block">
                        <span class="order-total-label">Total</span>
                        <span class="order-total-amount">{{ $order['total'] }}</span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="order-actions">
                    @if($order['status'] == 0)
                        <a href="{{ route('order.confirm', request()->route('id')) }}" class="btn-primary order-btn">
                            ✓ Confirmar Orden
                        </a>
                        <a href="{{ route('order.cancel', request()->route('id')) }}" class="btn-ghost order-btn">
                            Cancelar
                        </a>
                    @else
                        <div class="order-closed-notice">
                            <span>🔒</span>
                            Esta orden ya fue cerrada
                        </div>
                    @endif
                </div>

            </aside>
        </div>

    </div>
@endsection

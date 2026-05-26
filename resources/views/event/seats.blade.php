
@extends('layouts.app')
@section('title', 'Seleccionar Asientos')

@section('content')
    <style>
        /* ─── SEATS PAGE ──────────────────────────────────────────── */

        .seats-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 2rem;
            align-items: start;
            margin-bottom: 2rem;
        }

        /* ── Seat map panel ── */
        .seats-container {
            background: var(--bg-panel);
            border: 1px solid var(--line);
            border-radius: var(--r-lg);
            padding: 1.75rem;
        }

        .seats-container-title {
            font-family: var(--font-head);
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--txt);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        /* Legend */
        .seats-legend {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-family: var(--font-mono);
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--txt-dim);
        }

        .legend-seat {
            width: 16px;
            height: 16px;
            border-radius: 3px;
            flex-shrink: 0;
        }

        .legend-seat.available {
            background: #4CAF50;
            box-shadow: 0 0 6px rgba(76,175,80,0.4);
        }

        .legend-seat.occupied {
            background: #f44336;
            box-shadow: 0 0 6px rgba(244,67,54,0.3);
        }

        .legend-seat.selected {
            background: var(--or);
            box-shadow: 0 0 6px var(--or-glow);
        }

        /* Seat map canvas wrapper */
        #seat-map {
            background: var(--bg-card2);
            border: 1px solid var(--line);
            border-radius: var(--r-md);
            min-height: 400px;
            overflow: hidden;
            position: relative;
        }

        /* ── Sidebar summary ── */
        .showtime-info {
            background: var(--bg-panel);
            border: 1px solid var(--line);
            border-radius: var(--r-lg);
            padding: 1.75rem;
            position: sticky;
            top: 84px;
            height: fit-content;
        }

        .showtime-info-title {
            font-family: var(--font-mono);
            font-size: 0.68rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--txt-faint);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .showtime-info-title::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 2px;
            background: var(--or);
            flex-shrink: 0;
        }

        .info-item {
            padding: 0.9rem 0;
            border-bottom: 1px solid var(--line);
        }

        .info-item:last-of-type {
            border-bottom: none;
        }

        .info-label {
            font-family: var(--font-mono);
            font-size: 0.62rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--txt-faint);
            margin-bottom: 0.35rem;
        }

        .info-value {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--txt);
        }

        .info-value.price {
            color: var(--or);
            font-family: var(--font-head);
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        /* Selected seats box */
        .selected-seats-display {
            background: var(--bg-card2);
            border: 1px solid var(--line);
            border-radius: var(--r-md);
            padding: 1rem;
            margin: 1.25rem 0;
            min-height: 52px;
        }

        .selected-seats-display p {
            font-family: var(--font-mono);
            font-size: 0.66rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--txt-faint);
            margin: 0 0 0.4rem;
        }

        .selected-seats-display .seats-list {
            font-family: var(--font-mono);
            font-size: 0.82rem;
            color: var(--or);
            font-weight: 500;
            letter-spacing: 0.04em;
        }

        /* Total price block */
        .total-price {
            background: var(--or-glow);
            border: 1px solid var(--line-or);
            border-radius: var(--r-md);
            padding: 1rem 1.25rem;
            text-align: center;
            margin: 1.25rem 0;
        }

        .total-price .label {
            font-family: var(--font-mono);
            font-size: 0.66rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--or);
            opacity: 0.8;
        }

        .total-price .amount {
            font-family: var(--font-head);
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--or);
            line-height: 1.1;
        }

        /* Form actions */
        .form-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .form-actions .btn-primary,
        .form-actions .btn-ghost {
            width: 100%;
            justify-content: center;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .seats-layout {
                grid-template-columns: 1fr;
            }
            .showtime-info {
                position: static;
            }
        }

        @media (max-width: 600px) {
            .seats-container { padding: 1.25rem; }
            .showtime-info { padding: 1.25rem; }
            .seats-legend { gap: 1rem; }
            #seat-map { min-height: 300px; }
        }
    </style>

    <a href="javascript:history.back()" class="back-link">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
            <path d="M9 2L4 7L9 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        Volver
    </a>

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

            <div id="seat-map"></div>
        </div>

        <!-- Showtime Info & Purchase -->
        <div class="showtime-info">
            <div class="showtime-info-title">Resumen de Compra</div>

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
                <input type="hidden" name="seats" id="seatsInput" />
                <button type="submit" class="btn-primary" id="submitBtn">🎫 Registrar Compra</button>
                <a href="" class="btn-ghost" style="text-align: center; text-decoration: none;">Cancelar</a>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/konva@10/konva.min.js"></script>
        <script>
            const seats = @js($seats);
            const basePrice = {{ $showtime['basePrice'] }};
            const selectedSeats = [];

            // Crear Stage
            const stage = new Konva.Stage({
                container: 'seat-map',
                width: window.innerWidth > 1024 ? 700 : 500,
                height: 400
            });

            const layer = new Konva.Layer();
            stage.add(layer);

            // Obtener filas únicas
            const rowsLetters = [...new Set(seats.map(seat => String(seat.row)))].sort();
            const maxColumn = Math.max(...seats.map(seat => seat.number));

            // Espaciado de asientos
            const seatRadius = 10;
            const seatSpacing = 30;
            const rowSpacing = 40;
            const startX = 50;
            const startY = 50;

            // Función toggle de asientos
            function toggleSeat(seat, circle) {
                const index = selectedSeats.indexOf(seat.id);

                if (index !== -1) {
                    selectedSeats.splice(index, 1);
                    circle.fill('#4CAF50');
                } else {
                    selectedSeats.push(seat.id);
                    circle.fill('#FD7B41');
                }

                updateDisplay();
                layer.draw();
            }

            // Función para actualizar la pantalla
            function updateDisplay() {
                const selectedCount = selectedSeats.length;
                const totalCost = selectedCount * basePrice;

                // Actualizar asientos seleccionados
                if (selectedCount === 0) {
                    document.getElementById('selectedSeatsDisplay').textContent = 'Ninguno';
                } else {
                    document.getElementById('selectedSeatsDisplay').textContent = selectedSeats.join(', ');
                }

                // Actualizar precio total
                document.getElementById('totalPrice').textContent = '$' + totalCost.toFixed(2);

                // Actualizar input oculto
                document.getElementById('seatsInput').value = JSON.stringify(selectedSeats);

                // Habilitar/deshabilitar botón
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = selectedCount === 0;
                submitBtn.style.opacity = selectedCount === 0 ? '0.5' : '1';
                submitBtn.style.cursor = selectedCount === 0 ? 'not-allowed' : 'pointer';
            }

            // Dibujar asientos
            seats.forEach(seat => {
                const rowIndex = rowsLetters.indexOf(String(seat.row));
                const x = startX + seat.number * seatSpacing;
                const y = startY + rowIndex * rowSpacing;

                const drawnSeat = new Konva.Circle({
                    x: x,
                    y: y,
                    radius: seatRadius,
                    fill: seat.status === 0 ? '#4CAF50' : '#f44336',
                    stroke: seat.status === 0 ? '#388E3C' : '#d32f2f',
                    strokeWidth: 2,
                    id: seat.id
                });

                // Agregar evento click solo a asientos disponibles
                if (seat.status === 0) {
                    drawnSeat.on('click', () => {
                        toggleSeat(seat, drawnSeat);
                    });
                    drawnSeat.on('mouseover', () => {
                        drawnSeat.scale({ x: 1.2, y: 1.2 });
                        layer.draw();
                    });
                    drawnSeat.on('mouseout', () => {
                        drawnSeat.scale({ x: 1, y: 1 });
                        layer.draw();
                    });
                    drawnSeat.cursor = 'pointer';
                }

                layer.add(drawnSeat);

                // Agregar etiqueta de asiento
                const label = new Konva.Text({
                    x: x - 12,
                    y: y - 6,
                    text: seat.number.toString(),
                    fontSize: 10,
                    fontFamily: 'Inter, sans-serif',
                    fill: '#fff',
                    align: 'center',
                    pointerEvents: 'none'
                });

                layer.add(label);
            });

            layer.draw();

            // Redimensionar canvas cuando cambia el tamaño de la ventana
            window.addEventListener('resize', () => {
                const newWidth = window.innerWidth > 1024 ? 700 : 500;
                stage.width(newWidth);
            });

            updateDisplay();
        </script>
    @endpush

@endsection

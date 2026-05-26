@extends('layouts.app')
@section('title', 'Event Display')

@section('content')
    <article>
        <h1>Seats Map</h1>
        <!-- DISPLAY OF SEATS -->
        <div id="seat-map">

        </div>
    </article>
    <article>
        <!-- SHOWTIME INFORMATION -->
        <h2>Informacion de la Funcion</h2>

        <p>Dia: {{ \Carbon\Carbon::parse($showtime['startTime'])->format('d/m/Y') }}</p>
        <p>Hora de Inicio: {{ \Carbon\Carbon::parse($showtime['startTime'])->format('H:i') }}</p>
        <p>Hora de Fin: {{ \Carbon\Carbon::parse($showtime['endTime'])->format('H:i') }}</p>
        <p>Precio por Ticket: {{ $showtime['basePrice'] }}$</p>
    </article>
@endsection

@push('scripts')
    <script src="https://unpkg.com/konva@10/konva.min.js"></script>
    <script>
        const seats = @js($seats);

        // Creating container
        const stage = new Konva.Stage({
            container: 'seat-map',
            width: 1000,
            height: 300
        });

        // Creating "drawer paper"
        const layer = new Konva.Layer();
        stage.add(layer);

        // Select seats handler
        function toggleSeat(seat, circle) {
            const index = selectedSeats.indexOf(seat.id);

            // If the seat is in selected seats, it remove it (unselect)
            if(index !== -1) {
                // Removing seat
                selectedSeats.splice(index, 1);
                circle.fill('gray');
            } else {
                // Add the seat
                selectedSeats.push(seat.id);
                circle.fill('gray');
            }

            // Updating layout
            layer.draw();
        }

        // Drawing seats
        seats.forEach(seat => {
            // Drawing seat
            const drawedSeat = new Konva.Circle({
                x: seat.number * 25,
                y: Number(seat.row) * 25,
                radius: 10,
                fill: seat.status == 0 ? "green" : "red"
            });

            // Adding event handler
            if(seat.status == 0) {
                circle.on('click', () => {

                })
            }

            // Adding to layout
            layer.add(drawedSeat);
        })
    </script>
@endpush

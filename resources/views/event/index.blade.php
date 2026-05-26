@extends('layouts.app')
@section('title', 'Event Display')

@section('content')
    <section>
        <article>
            <!-- DISPLAY EVENT INFORMATION -->
            <img src="{{ $event['posterUrl'] }}" alt="{{ $event['name'] }}">
            <h1>{{ $event['name'] }}</h1>
            <p>{{ $event['description'] }}</p>
            <h3>Venue</h3>
            <p>{{ $event['venueName'] }} - {{ $event['venueCity'] }}</p>
            <span>
            @switch($event['type'])
                    @case(0)
                        Concierto
                        @break
                    @case(1)
                        Pelicula
                        @break
                @endswitch
        </span>
            <span>{{ $event['durationMinutes'] }} minutos</span>
            <span>{{ $event['createdAt'] }}</span>
            <span>
            @if($event['isActive'])
                    Activo
                @else
                    Unactivo
                @endif
        </span>
        </article>
        <artticle>
            <!-- SHOWTIMES -->
            <h3>Horarios Disponibles</h3>

            <form action="{{ route('event.display-seats', $event['id']) }}" method="post">
                @csrf

                <label for="showtimeId">Horarios disponibles</label>
                <select required name="showtimeId">
                    <option selected disabled value="">Selecciona una opcion</option>
                    @foreach($showtimes as $showtime)
                        <option value="{{ $showtime['id'] }}">{{ \Carbon\Carbon::parse($showtime['startTime'])->format('d/m/Y') }} {{ \Carbon\Carbon::parse($showtime['startTime'])->format('H:i') }}</option>
                    @endforeach
                </select>

                <button type="submit">View seats</button>
            </form>
        </artticle>
    </section>
@endsection

@extends('layouts.app')
@section('title', 'Funciones de Evento')

@section('content')
    <a href="{{ route('catalog.index') }}" class="back-link">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
            <path d="M9 2L4 7L9 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        Volver al Catálogo
    </a>

    <section class="event-detail-grid">

        {{-- ── LEFT ── --}}
        <div class="event-poster-col">
            <div class="event-poster-frame corner-decor">
                <!-- DISPLAY EVENT INFORMATION -->
                <img src="{{ $event['posterUrl'] }}" alt="{{ $event['name'] }}">

                <div class="poster-overlay-title">
                    <h1>{{ $event['name'] }}</h1>
                    <div class="poster-overlay-badges">
                    <span class="badge badge-or">
                        @switch($event['type'])
                            @case(0) Concierto @break
                            @case(1) Pelicula  @break
                        @endswitch
                    </span>
                        @if($event['isActive'])
                            <span class="badge badge-green">● Activo</span>
                        @else
                            <span class="badge badge-red">● Unactivo</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="meta-grid">
                <div class="meta-cell">
                    <div class="meta-key">Duración</div>
                    <div class="meta-val accent">{{ $event['durationMinutes'] }} min</div>
                </div>
                <div class="meta-cell">
                    <div class="meta-key">Creado</div>
                    <div class="meta-val">{{ \Carbon\Carbon::parse($event['createdAt'])->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>

        {{-- ── RIGHT ── --}}
        <div class="event-info-col">

            <div class="panel-title" style="margin-bottom:0;">INFORMACIÓN DEL EVENTO</div>

            <div class="event-description-panel">
                <p>{{ $event['description'] }}</p>
            </div>

            <div class="venue-strip">
                <div class="venue-icon">📍</div>
                <div class="venue-text">
                    <div class="venue-name">{{ $event['venueName'] }}</div>
                    <div class="venue-city">{{ $event['venueCity'] }}</div>
                </div>
            </div>

            {{-- SHOWTIMES --}}
            <div class="showtimes-panel corner-decor">
                <div class="showtimes-header">
                    <h3>Horarios Disponibles</h3>
                    <span class="badge badge-dim">{{ count($showtimes) }} funciones</span>
                </div>

                <ul class="showtime-list">
                    @forelse($showtimes as $showtime)
                        <li>
                            <a href="{{ route('event.display-seats', $showtime['id']) }}">
                                <span class="showtime-bullet"></span>
                                <div class="showtime-date-block">
                                    <div class="s-date">{{ \Carbon\Carbon::parse($showtime['startTime'])->format('d/m/Y') }}</div>
                                    <div class="s-time">{{ \Carbon\Carbon::parse($showtime['startTime'])->format('H:i') }}</div>
                                </div>
                                <span class="showtime-arrow">→</span>
                            </a>
                        </li>
                    @empty
                        <li class="showtime-empty">Sin horarios disponibles</li>
                    @endforelse
                </ul>
            </div>

        </div>
    </section>
@endsection

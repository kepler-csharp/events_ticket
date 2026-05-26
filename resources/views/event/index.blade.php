@extends('layouts.app')
@section('title', 'Event Display')

@section('content')
    <style>
        /* ─── EVENT DETAIL ────────────────────────────────────────── */

        .event-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: start;
        }

        /* ── LEFT: Poster + meta ── */
        .event-poster-col { position: sticky; top: 90px; }

        .event-poster-frame {
            border-radius: var(--r-lg);
            overflow: hidden;
            border: 1px solid var(--line);
            position: relative;
            aspect-ratio: 2/3;
            max-height: 480px;
            background: var(--bg-card2);
        }

        .event-poster-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            filter: brightness(0.9);
        }

        /* gradient fade at bottom */
        .event-poster-frame::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 50%, rgba(13,14,16,0.8) 100%);
        }

        /* title overlaid on poster */
        .poster-overlay-title {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            z-index: 2;
            padding: 1.5rem;
        }

        .poster-overlay-title h1 {
            font-family: var(--font-head);
            font-size: clamp(1.4rem, 3vw, 2rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #fff;
            line-height: 1.1;
            text-shadow: 0 2px 12px rgba(0,0,0,0.5);
        }

        .poster-overlay-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            margin-top: 0.75rem;
        }

        /* meta data grid below poster */
        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1px;
            background: var(--line);
            border: 1px solid var(--line);
            border-radius: var(--r-md);
            overflow: hidden;
            margin-top: 1.25rem;
        }

        .meta-cell {
            background: var(--bg-panel);
            padding: 1rem 1.1rem;
        }

        .meta-cell .meta-key {
            font-family: var(--font-mono);
            font-size: 0.62rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--txt-faint);
            margin-bottom: 0.35rem;
        }

        .meta-cell .meta-val {
            font-weight: 600;
            font-size: 0.92rem;
            color: var(--txt);
        }

        .meta-cell .meta-val.accent { color: var(--or); }

        /* ── RIGHT: Info + showtimes ── */
        .event-info-col { display: flex; flex-direction: column; gap: 1.5rem; }

        .event-description-panel {
            background: var(--bg-panel);
            border: 1px solid var(--line);
            border-radius: var(--r-lg);
            padding: 1.5rem;
        }

        .event-description-panel p {
            color: var(--txt-dim);
            font-size: 0.95rem;
            line-height: 1.75;
        }

        /* Venue strip */
        .venue-strip {
            background: var(--bg-card2);
            border: 1px solid var(--line);
            border-radius: var(--r-md);
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .venue-icon {
            width: 36px;
            height: 36px;
            background: var(--or-glow);
            border: 1px solid var(--line-or);
            border-radius: 8px;
            display: grid;
            place-items: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .venue-text .venue-name {
            font-weight: 600;
            color: var(--txt);
            font-size: 0.95rem;
        }

        .venue-text .venue-city {
            font-family: var(--font-mono);
            font-size: 0.7rem;
            color: var(--txt-faint);
            letter-spacing: 0.06em;
            margin-top: 0.2rem;
        }

        /* ── SHOWTIMES ── */
        .showtimes-panel {
            background: var(--bg-panel);
            border: 1px solid var(--line);
            border-radius: var(--r-lg);
            overflow: hidden;
        }

        .showtimes-header {
            padding: 1.1rem 1.5rem;
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .showtimes-header h3 {
            font-family: var(--font-head);
            font-size: 1rem;
            font-weight: 800;
            letter-spacing: -0.01em;
        }

        .showtime-list {
            list-style: none;
        }

        .showtime-list li {
            border-bottom: 1px solid var(--line);
            transition: var(--t);
        }

        .showtime-list li:last-child { border-bottom: none; }

        .showtime-list li:hover {
            background: var(--bg-card2);
        }

        .showtime-list li a {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            text-decoration: none;
            color: var(--txt);
            transition: var(--t);
        }

        .showtime-list li a:hover { color: var(--or); }

        .showtime-bullet {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--or);
            flex-shrink: 0;
            box-shadow: 0 0 6px var(--or);
        }

        .showtime-date-block {
            flex: 1;
        }

        .showtime-date-block .s-date {
            font-family: var(--font-mono);
            font-size: 0.72rem;
            color: var(--txt-dim);
            letter-spacing: 0.06em;
        }

        .showtime-date-block .s-time {
            font-family: var(--font-head);
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--txt);
            line-height: 1.1;
        }

        .showtime-arrow {
            font-family: var(--font-mono);
            font-size: 0.75rem;
            color: var(--txt-faint);
            transition: var(--t);
        }

        .showtime-list li a:hover .showtime-arrow {
            color: var(--or);
            transform: translateX(4px);
        }

        .showtime-empty {
            padding: 3rem;
            text-align: center;
            font-family: var(--font-mono);
            font-size: 0.75rem;
            color: var(--txt-faint);
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .event-detail-grid {
                grid-template-columns: 1fr;
            }
            .event-poster-col { position: static; }
            .event-poster-frame { max-height: 340px; aspect-ratio: 16/9; }
        }
    </style>

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
                    <div class="meta-val">{{ $event['createdAt'] }}</div>
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

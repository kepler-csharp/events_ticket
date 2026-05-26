
@extends('layouts.app')
@section("title", "Catálogo de Eventos")

@section("content")
    <style>
        /* ─── CATALOG PAGE ────────────────────────────────────────── */

        /* Top bar with search */
        .catalog-top {
            display: flex;
            gap: 1.5rem;
            align-items: flex-end;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .search-wrap {
            flex: 1;
            min-width: 260px;
            position: relative;
        }

        .search-wrap label {
            display: block;
            margin-bottom: 0.5rem;
        }

        .search-wrap input {
            padding-left: 2.8rem;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            bottom: 0.82rem;
            color: var(--txt-faint);
            font-size: 0.9rem;
            pointer-events: none;
            font-family: var(--font-mono);
        }

        .search-wrap input:focus + .search-icon,
        .search-wrap:focus-within .search-icon {
            color: var(--or);
        }

        /* ─── FILTER STRIP ────────────────────────────────────────── */
        /* Approach: hide checkboxes visually, style labels as toggle pills.
           When checkbox is :checked, the adjacent label gets active styles via JS class.
           Pure CSS sibling selector can't reach label after input across DOM positions,
           so we use a tiny JS snippet below (no hrefs/routes touched). */

        .filters-bar {
            background: var(--bg-panel);
            border: 1px solid var(--line);
            border-radius: var(--r-lg);
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filters-label {
            font-family: var(--font-mono);
            font-size: 0.68rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--txt-faint);
            flex-shrink: 0;
            padding-right: 1rem;
            border-right: 1px solid var(--line);
        }

        .filter-group {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            align-items: center;
            flex: 1;
        }

        /* HIDE the actual checkbox — kept in DOM for form submission */
        .filter-group input[type="checkbox"] {
            position: absolute;
            width: 1px;
            height: 1px;
            opacity: 0;
            pointer-events: none;
        }

        /* Labels look like pills / toggle buttons */
        .filter-group label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: var(--font-mono);
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--txt-dim);
            background: var(--bg-card);
            border: 1px solid var(--line);
            border-radius: 5px;
            padding: 0.45rem 0.9rem;
            cursor: pointer;
            transition: var(--t);
            user-select: none;
        }

        .filter-group label:hover {
            border-color: rgba(253,123,65,0.4);
            color: var(--txt);
            background: var(--bg-card2);
        }

        /* Active state (toggled on) — applied via JS when checkbox is checked */
        .filter-group label.filter-active {
            background: var(--or-glow);
            border-color: var(--or);
            color: var(--or);
            box-shadow: 0 0 10px var(--or-glow);
        }

        .filters-apply {
            margin-left: auto;
            flex-shrink: 0;
        }

        /* ─── EVENTS GRID ─────────────────────────────────────────── */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            align-items: start;
        }

        .empty-state {
            grid-column: 1 / -1;
            padding: 5rem 2rem;
            text-align: center;
        }

        .empty-state .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.15;
            display: block;
        }

        .empty-state p {
            color: var(--txt-faint);
            font-family: var(--font-mono);
            font-size: 0.8rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        /* grid line accent on top of heading */
        .section-heading {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .section-heading h2 {
            font-family: var(--font-head);
            font-size: 1.05rem;
            font-weight: 800;
            letter-spacing: -0.01em;
            color: var(--txt);
        }

        .section-heading .count {
            font-family: var(--font-mono);
            font-size: 0.7rem;
            color: var(--or);
            background: var(--or-glow);
            border: 1px solid var(--line-or);
            padding: 0.2rem 0.6rem;
            border-radius: 4px;
        }

        .section-heading::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--line);
        }
    </style>

    {{-- ─── PAGE HEADING ─────────────────────────────────────── --}}
    <div class="page-heading">
        <div class="eyebrow">MÓDULO DE RECEPCIÓN · CATÁLOGO</div>
        <h1>Eventos <em>Disponibles</em></h1>
        <p>Selecciona un evento para ver horarios y registrar tickets de clientes.</p>
    </div>

    {{-- ─── ERROR ────────────────────────────────────────────── --}}
    @error('failedReq')
    <div class="alert-error">{{ $message }}</div>
    @enderror

    {{-- ─── SEARCH BAR ───────────────────────────────────────── --}}
    <form action="{{ route('catalog.search') }}" method="post">
        @csrf
        <div class="catalog-top">
            <div class="search-wrap">
                <label for="eventName">Buscar Evento</label>
                <input type="text" id="eventName" name="eventName"
                       value="{{ old('eventName') }}"
                       placeholder="Nombre del evento..." />
                <span class="search-icon">⌕</span>
            </div>
            <button type="submit" class="btn-primary">Buscar</button>
        </div>
    </form>

    {{-- ─── FILTERS ──────────────────────────────────────────── --}}
    <form>
        @csrf
        <div class="filters-bar">
            <span class="filters-label">Filtrar</span>
            <div class="filter-group">
                <label for="filterToday">Hoy</label>
                <input type="checkbox" name="filters[]" value="1" id="filterToday">

                <label for="filterActive">Activos</label>
                <input type="checkbox" name="filters[]" value="2" id="filterActive">

                <label for="filterWeek">Esta Semana</label>
                <input type="checkbox" name="filters[]" value="3" id="filterWeek">

                <label for="filterMovies">Películas</label>
                <input type="checkbox" name="filters[]" value="4" id="filterMovies">

                <label for="filterConcerts">Conciertos</label>
                <input type="checkbox" name="filters[]" value="5" id="filterConcerts">
            </div>
            <button type="submit" class="btn-primary filters-apply">Aplicar</button>
        </div>
    </form>

    {{-- ─── EVENTS ───────────────────────────────────────────── --}}
    <div class="section-heading">
        <h2>Resultados</h2>
        @if(count($events) > 0)
            <span class="count">{{ count($events) }} eventos</span>
        @endif
    </div>

    <section class="events-grid">
        @if(count($events) > 0)
            @foreach($events as $event)
                <x-event-card :data="$event" />
            @endforeach
        @else
            <div class="empty-state">
                <span class="empty-icon">◻</span>
                <p>No hay eventos disponibles</p>
            </div>
        @endif
    </section>

    {{-- Pagination --}}

    {{-- ─── FILTER TOGGLE JS ─────────────────────────────────── --}}
    <script>
        // Sync checkbox state → label visual state (no hrefs/routes changed)
        document.querySelectorAll('.filter-group input[type="checkbox"]').forEach(cb => {
            const label = document.querySelector('label[for="' + cb.id + '"]');
            if (!label) return;

            // Restore state on page load (e.g. after back navigation)
            if (cb.checked) label.classList.add('filter-active');

            label.addEventListener('click', () => {
                // Let browser toggle the checkbox first (next tick)
                setTimeout(() => {
                    label.classList.toggle('filter-active', cb.checked);
                }, 0);
            });
        });
    </script>
@endsection

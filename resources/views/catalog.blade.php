
@extends('layouts.app')
@section("title", "Catálogo de Eventos")

@section("content")
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
    <form action="{{ route('catalog.index') }}" method="get">
        @csrf
        <div class="catalog-top">
            <div class="search-wrap">
                <label for="eventName">Buscar Evento</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name') }}"
                       placeholder="Nombre del evento..." />
                <span class="search-icon">⌕</span>
            </div>
            <button type="submit" class="btn-primary">Buscar</button>
        </div>
    </form>

    {{-- ─── FILTERS ──────────────────────────────────────────── --}}
    <form action="{{ route('catalog.index') }}" method="get">
        @csrf
        <div class="filters-bar">
            <span class="filters-label">Filtrar</span>
            <div class="filter-group">
                <label for="filterActive">Activos</label>
                <input type="checkbox" name="active" id="filterActive">

                <label for="filterMovies">Películas</label>
                <input type="checkbox" name="movies" id="filterMovies">

                <label for="filterConcerts">Conciertos</label>
                <input type="checkbox" name="concerts" id="filterConcerts">
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
@endsection

@extends('layouts.app')

@section('title', 'Recepcion Virtual')

@section('content')

    <section class="p-8 max-w-7xl mx-auto">

        <div class="mb-10">
            <h2 class="text-3xl font-bold">
                Selección de Evento
            </h2>

            <p class="text-on-surface-variant">
                Explora los eventos disponibles.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <p>No hay eventos actuales</p>
            <!--<x-event-card
                title="Filarmónica Metropolitana"
                location="Teatro de la Ciudad"
                date="DIC 15"
                image="https://..."
                status="available"
            />

            <x-event-card
                title="Vanguardia Musical"
                location="Foro Alternativo"
                date="ENE 22"
                image="https://..."
                status="limited"
            />-->

        </div>

    </section>

@endsection

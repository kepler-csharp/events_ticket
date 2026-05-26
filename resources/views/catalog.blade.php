@extends('layouts.app')
@section("title", "Catálogo de Eventos")

@section("content")
    <!-- Display server connection errors -->
    @error('failedReq')
        <p>{{ $message }}</p>
    @enderror

    <!-- Search Bar -->
    <form action="{{ route('catalog.search') }}" method="post">
        @csrf

        <label for="eventName">Search any event: </label>
        <input type="text" id="eventName" name="eventName" value="{{ old('eventName') }}" />

        <button type="submit">Search</button>
    </form>

    <!-- Filters -->
    <form>
        @csrf

        <label for="filterToday">Today</label>
        <input type="checkbox" name="filters[]" value="1" id="filterToday">

        <label for="filterActive">Active</label>
        <input type="checkbox" name="filters[]" value="2" id="filterActive">

        <label for="filterWeek">This Week</label>
        <input type="checkbox" name="filters[]" value="3" id="filterWeek">

        <label for="filterMovies">Movies</label>
        <input type="checkbox" name="filters[]" value="4" id="filterMovies">

        <label for="filterConcerts">Concerts</label>
        <input type="checkbox" name="filters[]" value="5" id="filterConcerts">

        <button>Apply Filters</button>
    </form>

    <!-- Displaying events catalog -->
    <section>
        @if(count($events) > 0)
            @foreach($events as $event)
                <x-event-card :data="$event" />
            @endforeach
        @else
            <p>There isn't any event</p>
        @endif
    </section>

    <!-- Pagination -->

@endsection

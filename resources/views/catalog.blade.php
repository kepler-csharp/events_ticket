@extends('layouts.app')
@section("title", "Catálogo de Eventos")

@section("content")
    <!-- Display server connection errors -->
    @error('serverError')
        <p>{{ $message }}</p>
    @enderror

    <!-- Search Bar -->
    <form action="" method="post">
        @csrf

        <label for="eventToSearch">Search any event: </label>
        <input type="text" id="eventToSearch" name="eventToSearch" />

        <button type="submit">Search</button>
    </form>

    <!-- Filters -->
    <form>
        @csrf

        <label for="filterToday">Today</label>
        <input type="checkbox" name="filterToday" id="filterToday">

        <label for="filterActive">Active</label>
        <input type="checkbox" name="filterActive" id="filterActive">

        <label for="filterWeek">This Week</label>
        <input type="checkbox" name="filterWeek" id="filterWeek">

        <label for="filterMovies">Movies</label>
        <input type="checkbox" name="filterMovies" id="filterMovies">

        <label for="filterConcerts">Concerts</label>
        <input type="checkbox" name="filterConcerts" id="filterConcerts">

        <button>Apply Filters</button>
    </form>

    <!-- Displaying events catalog -->
    <section>
        @foreach($events as $event)
            @foreach($event as $unique_event)
                <x-event-card :data="$unique_event" />
            @endforeach
        @endforeach
    </section>

    <!-- Pagination -->
@endsection

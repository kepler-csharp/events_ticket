@props([
    'data'
])

<article>
    <img src="{{ $data['posterUrl'] }}" alt="{{ $data['name'] }}">
    <h3>{{ $data['name'] }}</h3>
    <p>{{ $data['description'] }}</p>
    <span>{{ $data['venueCity'] }}</span>
    <span>{{ $data['type'] == 1 ? 'Concierto' : 'Pelicula' }}</span>

    <button>See more</button>
</article>

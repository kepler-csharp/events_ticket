@props([
    'data'
])

<article class="ev-card">
    <div class="ev-card-img-wrap">
        <img src="{{ $data['posterUrl'] }}" alt="{{ $data['name'] }}">
        <span class="ev-type-badge">
            {{ $data['type'] == 1 ? 'Concierto' : 'Pelicula' }}
        </span>
    </div>

    <div class="ev-card-body">
        <h3 class="ev-card-name">{{ $data['name'] }}</h3>
        <p class="ev-card-desc">{{ $data['description'] }}</p>
        <div class="ev-card-meta">
            @if(isset($data['isActive']))
                @if($data['isActive'])
                    <span class="badge badge-green">● Activo</span>
                @else
                    <span class="badge badge-red">● Inactivo</span>
                @endif
            @endif
        </div>
    </div>

    <div class="ev-card-footer">
        <span class="ev-city">{{ $data['venueCity'] }}</span>
        <a href="{{ route('event.index', $data['id']) }}" class="ev-card-link">Ver Evento</a>
    </div>
</article>

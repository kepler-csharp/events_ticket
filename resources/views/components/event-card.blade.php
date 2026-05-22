@props([
    'title',
    'location',
    'date',
    'image',
    'status' => 'available'
])

<article
    class="event-card group"
>
    <div class="relative aspect-video overflow-hidden">
        <img
            src="{{ $image }}"
            alt="{{ $title }}"
            class="event-card-image"
        >
    </div>

    <div class="p-4 flex flex-col flex-grow">

        <div class="flex justify-between items-start mb-2">
            <h3 class="text-xl font-bold leading-tight">
                {{ $title }}
            </h3>

            <span class="text-primary font-bold">
                {{ $date }}
            </span>
        </div>

        <div class="flex items-center gap-2 text-on-surface-variant mb-4">
            <span class="material-symbols-outlined text-[18px]">
                location_on
            </span>

            <span>
                {{ $location }}
            </span>
        </div>

        <div class="mt-auto">
            <button class="btn-primary select-event-btn">
                Seleccionar
            </button>
        </div>

    </div>
</article>

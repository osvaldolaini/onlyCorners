<div>
    @if (Storage::directoryMissing('public/logos-school'))
        <picture class="h-24 sm:h-16" {{ $attributes }}>
            <source srcset="{{ url('storage/logos/logo-gerencia.png') }}" />
            <source srcset="{{ url('storage/logos/logo-gerencia.webp') }}" />
            <img class="h-24" src="{{ url('storage/logos/logo-gerencia.png') }}" alt="api-gerencia">
        </picture>
    @else
        <picture class="h-24 sm:h-16" {{ $attributes }}>
            <source srcset="{{ url('storage/logos-school/logo.png') }}" />
            <source srcset="{{ url('storage/logos-school/logo.webp') }}" />
            <img class="h-24" src="{{ url('storage/logos-school/logo.png') }}" alt="api-gerencia">
        </picture>
    @endif
</div>

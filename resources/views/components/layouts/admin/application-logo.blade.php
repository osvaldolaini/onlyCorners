<div>
    @props(['width' => 'h-24 sm:h-16'])
    @if (Storage::directoryMissing('public/logos-school'))
        <picture>
            <source srcset="{{ url('storage/logos/logo-gerencia.png') }}" />
            <source srcset="{{ url('storage/logos/logo-gerencia.webp') }}" />
            <img class="{{ $width }}" src="{{ url('storage/logos/logo-gerencia.png') }}" alt="api-gerencia">
        </picture>
    @else
        <picture class="{{ $width }}">
            <source srcset="{{ url('storage/logos-school/logo.png') }}" />
            <source srcset="{{ url('storage/logos-school/logo.webp') }}" />
            <img class="{{ $width }}" src="{{ url('storage/logos-school/logo.png') }}" alt="api-gerencia">
        </picture>
    @endif
</div>
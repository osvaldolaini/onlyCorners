<div>
    @props(['width' => 'h-24 sm:h-16'])
    <picture>
        <source srcset="{{ url('storage/logos/logo.png') }}" />
        <source srcset="{{ url('storage/logos/logo.webp') }}" />
        <img class="{{ $width }}" src="{{ url('storage/logos/logo.png') }}" alt="only-corners">
    </picture>

</div>

@props(['sorts', 'field'])
<div class="inline-flex items-center cursor-pointer">
    {{ $slot }}
    @if (isset($sorts[$field]))
        @if ($sorts[$field] === 'desc')
            <div class="p-0 tooltip tooltip-bottom" data-tip="Decrescente">
                <span class="p-1 text-gray-900 transition-colors duration-200 whitespace-nowrap">
                    <svg class="w-6 h-6 ml-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 12H21M13 8H21M13 16H21M6 7V17M6 17L3 14M6 17L9 14" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </div>
        @else
            <div class="p-0 tooltip tooltip-bottom" data-tip="Crescente">
                <span class="p-1 text-gray-900 transition-colors duration-200 whitespace-nowrap">
                    <svg class="w-6 h-6 ml-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 12H21M13 8H21M13 16H21M6 7V17M6 7L3 10M6 7L9 10" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </div>
        @endif
    @else
        <div class="p-0 tooltip tooltip-bottom" data-tip="Crescente">
            <span class="p-1 text-gray-700 transition-colors duration-200 whitespace-nowrap">
                <svg class="w-6 h-6 ml-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 18L16 6M16 6L20 10.125M16 6L12 10.125" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 6L8 18M8 18L12 13.875M8 18L4 13.875" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
        </div>
    @endif

</div>

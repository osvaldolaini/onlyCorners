@props(['id', 'active'])

@if ($active == 1)
    <div class="tooltip tooltip-top p-0" data-tip="Desativar">
        <button wire:click="buttonActive({{ $id }})"
            class="py-2 px-3
                    hover:text-white text-green-500 dark:hover:bg-green-500 transition-colors hover:bg-green-500
                    duration-200 whitespace-nowrap">
            <svg class="h-6 w-6 " viewBox="0 -6 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                    sketch:type="MSPage">
                    <g id="Icon-Set-Filled" sketch:type="MSLayerGroup" transform="translate(-258.000000, -367.000000)"
                        fill="currentColor">
                        <path
                            d="M280,383 C276.687,383 274,380.313 274,377 C274,373.687 276.687,371 280,371 C283.313,371 286,373.687 286,377 C286,380.313 283.313,383 280,383 L280,383 Z M280,367 L268,367 C262.477,367 258,371.478 258,377 C258,382.522 262.477,387 268,387 L280,387 C285.523,387 290,382.522 290,377 C290,371.478 285.523,367 280,367 L280,367 Z M280,373 C277.791,373 276,374.791 276,377 C276,379.209 277.791,381 280,381 C282.209,381 284,379.209 284,377 C284,374.791 282.209,373 280,373 L280,373 Z"
                            id="toggle-off" sketch:type="MSShapeGroup">

                        </path>
                    </g>
                </g>
            </svg>
        @else
            <div class="tooltip tooltip-top p-0" data-tip="Ativar">
                <button wire:click="buttonActive({{ $id }})"
                    class="py-2 px-3
                    hover:text-white text-red-500 dark:hover:bg-red-500 transition-colors hover:bg-red-500
                    duration-200 whitespace-nowrap">
                    <svg class="h-6 w-6 " viewBox="0 -6 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">

                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                            sketch:type="MSPage">
                            <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-204.000000, -365.000000)"
                                fill="currentColor">
                                <path
                                    d="M214,379 C211.791,379 210,377.209 210,375 C210,372.791 211.791,371 214,371 C216.209,371 218,372.791 218,375 C218,377.209 216.209,379 214,379 L214,379 Z M214,369 C210.687,369 208,371.687 208,375 C208,378.313 210.687,381 214,381 C217.314,381 220,378.313 220,375 C220,371.687 217.314,369 214,369 L214,369 Z M226,383 L214,383 C209.582,383 206,379.418 206,375 C206,370.582 209.582,367 214,367 L226,367 C230.418,367 234,370.582 234,375 C234,379.418 230.418,383 226,383 L226,383 Z M226,365 L214,365 C208.477,365 204,369.478 204,375 C204,380.522 208.477,385 214,385 L226,385 C231.523,385 236,380.522 236,375 C236,369.478 231.523,365 226,365 L226,365 Z"
                                    id="toggle-on" sketch:type="MSShapeGroup">

                                </path>
                            </g>
                        </g>
                    </svg>
@endif

</button>
</div>

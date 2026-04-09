@props(['id' => null, 'active' => null])
<div class="w-full">
    <div class="flex justify-center font-medium duration-200">
        {{-- Opções visíveis em telas grandes --}}
        <div class="hidden space-x-1 md:flex">
            {{ $extra ?? '' }}
            @if (in_array('active', auth()->user()->jsonActivities))
                <x-table.table-toggle-active id='{{ $id }}'
                    active='{{ $active }}'></x-table.table-toggle-active>
            @endif
            @if (in_array('update', auth()->user()->jsonActivities))
                <div class="p-0 tooltip tooltip-top" data-tip="Editar">
                    <button wire:click="showUpdate({{ $id }})"
                        class="px-3 py-2 transition-colors duration-200 rounded-sm hover:text-white dark:hover:bg-blue-500 hover:bg-blue-500 whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                            </path>
                        </svg>
                    </button>
                </div>
            @endif
            @if (in_array('delete', auth()->user()->jsonActivities))
                <div class="p-0 tooltip tooltip-top" data-tip="Apagar">
                    <button wire:click="showModalDelete({{ $id }})"
                        class="px-3 py-2 -ml-1 transition-colors duration-200 rounded-sm dark:hover:bg-red-500 hover:bg-red-500 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
        {{-- SVG ... e Dropdown para telas pequenas --}}
        <div class="relative md:hidden">
            <div x-data="{ open: false }" class="inline-block text-left">
                <button @click="open = !open"
                    class="flex items-center w-full px-4 py-2 text-sm font-medium text-gray-800 transition-colors duration-300 dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 transition-transform duration-300"
                        :class="open ? 'rotate-90' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-transition
                    class="absolute z-50 px-2 mt-2 transition-transform duration-300 bg-gray-800 rounded-lg shadow-2xl w-36 right-3 sm:right-4 dark:bg-gray-100 dark:text-gray-900">
                    <div class="flex-row">
                        {{ $small ?? '' }}
                        @if (in_array('update', auth()->user()->jsonActivities))
                            <div class="w-full p-0 tooltip tooltip-top" data-tip="editar">
                                <button wire:click="showUpdate({{ $id }})"
                                    class="flex items-center pt-1 transition-colors duration-200 hover:text-white dark:hover:bg-blue-500 hover:bg-blue-500 whitespace-nowrap">
                                    <span>EDITAR</span>

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                        @if (in_array('delete', auth()->user()->jsonActivities))
                            <div class="w-full p-0 tooltip tooltip-top" data-tip="Apagar">
                                <button wire:click="showModalDelete({{ $id }})"
                                    class="flex items-center pt-1 transition-colors duration-200 dark:hover:bg-red-500 hover:bg-red-500 hover:text-white">
                                    <span>APAGAR</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                        @if (in_array('admin', auth()->user()->jsonGroups))
                            <x-table.table-toggle-active class="flex items-center w-full pt-1" id='{{ $id }}'
                                active='{{ $active }}'>
                            </x-table.table-toggle-active>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

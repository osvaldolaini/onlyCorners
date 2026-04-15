<div>
    @php
        use Carbon\Carbon;
    @endphp
    <x-layouts.breadcrumb>
        <x-slot name="left">
            <h3 class="text-2xl font-bold tracking-tight dark:text-gray-50">
                {{ $breadcrumb }}
            </h3>
        </x-slot>
    </x-layouts.breadcrumb>

    {{-- Botão Adicionar Novo Escanteio --}}
    <div class="flex justify-center my-8">
        <button wire:click="addRow"
            class="flex items-center gap-2 px-6 py-3 text-white bg-gray-700 hover:bg-blue-600 border border-gray-500 rounded-xl transition-all duration-200 font-medium">
            <span>Adicionar escanteio</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
        </button>
    </div>

    {{-- Lista de Escanteios --}}
    <div class="mx-auto">
        @foreach ($corners as $index => $corner)
            <div class="bg-gray-900 rounded-3xl overflow-hidden border border-gray-800 shadow-xl"
                wire:key="corner-{{ $corner->id }}">

                <!-- Cabeçalho -->
                <div
                    class="px-6 py-1 text-white bg-gray-950 border-b border-gray-800 flex justify-between items-center">
                    <div class="flex justify-between pl-2 col-span-full ">
                        <div class="p-0">
                            Lançado em
                            {{ Carbon::createFromFormat('Y-m-d H:i:s', $corner->created_at)->format('d/m/Y H:i:s') }}
                            por {{ $corner->created_by }}.
                        </div>
                    </div>

                    <button wire:click="removeRow({{ $corner->id }})"
                        class="text-red-500 hover:text-red-400 p-2 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 " viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 12L14 16M14 12L10 16M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>

                <div class="p-2 ">
                    <div class="grid grid-cols-2 gap-8">

                        <!-- COLUNA 1: Logos dos Times -->
                        <div>
                            <label class="block text-gray-400 text-sm font-medium mb-3">ESCANTEIO A FAVOR DE</label>
                            <div class="grid grid-cols-2 gap-4">

                                <!-- Time da Casa -->
                                <button wire:click="updateCornerTeam({{ $corner->id }}, {{ $corner->team?->id }})"
                                    class="cursor-pointer p-4 rounded-3xl border-2 transition-all flex flex-col items-center gap-3
                                           {{ $corner->favored_id == $corner->team?->id ? 'border-emerald-500 bg-emerald-950/60' : 'border-transparent bg-gray-800 hover:bg-gray-700' }}">
                                    <div
                                        class="w-16 h-16 bg-gray-700 rounded-2xl flex items-center justify-center overflow-hidden">
                                        @if ($corner->team?->code_image)
                                            <img src="{{ url('storage/teams/' . $corner->team->id . '/' . $corner->team->code_image . '_list.png') }}"
                                                alt="{{ $corner->team->nick }}" class="w-14 h-14 object-contain">
                                        @else
                                            <x-application-logo width="h-14" />
                                        @endif
                                    </div>
                                    <p class="font-medium text-white text-sm text-center line-clamp-1">
                                        {{ $corner->team?->title ?? 'Time Casa' }}
                                    </p>
                                </button>

                                <!-- Time Visitante -->
                                <button
                                    wire:click="updateCornerTeam({{ $corner->id }}, {{ $corner->opponent?->id }})"
                                    class="cursor-pointer p-4 rounded-3xl border-2 transition-all flex flex-col items-center gap-3
                                           {{ $corner->favored_id == $corner->opponent?->id ? 'border-emerald-500 bg-emerald-950/60' : 'border-transparent bg-gray-800 hover:bg-gray-700' }}">
                                    <div
                                        class="w-16 h-16 bg-gray-700 rounded-2xl flex items-center justify-center overflow-hidden">
                                        @if ($corner->opponent?->code_image)
                                            <img src="{{ url('storage/teams/' . $corner->opponent->id . '/' . $corner->opponent->code_image . '_list.png') }}"
                                                alt="{{ $corner->opponent->nick }}" class="w-14 h-14 object-contain">
                                        @else
                                            <x-application-logo width="h-14" />
                                        @endif
                                    </div>
                                    <p class="font-medium text-white text-sm text-center line-clamp-1">
                                        {{ $corner->opponent?->nick ?? 'Time Visitante' }}
                                    </p>
                                </button>

                            </div>
                        </div>

                        <!-- COLUNA 2: Tempo e Minuto -->
                        <div class="space-y-6">

                            <!-- Tempo -->
                            <div>
                                <label class="block text-gray-400 text-sm font-medium mb-3">TEMPO</label>
                                <div class="flex gap-2">
                                    <button wire:click="updateCornerHalf({{ $corner->id }}, 'first')"
                                        class="cursor-pointer flex-1 py-3.5 rounded-2xl font-bold text-sm transition-all
                                               {{ $corner->half == 'first' ? 'bg-emerald-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                                        1º TEMPO
                                    </button>
                                    <button wire:click="updateCornerHalf({{ $corner->id }}, 'second')"
                                        class="cursor-pointer flex-1 py-3.5 rounded-2xl font-bold text-sm transition-all
                                               {{ $corner->half == 'second' ? 'bg-emerald-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                                        2º TEMPO
                                    </button>
                                </div>
                            </div>

                            <!-- Minuto -->
                            <div>
                                <label class="block text-gray-400 text-sm font-medium mb-3">MINUTO</label>
                                <div class="flex items-center bg-gray-950 border border-gray-700 rounded-3xl p-2">
                                    <button wire:click="decrementMinute({{ $corner->id }})"
                                        class="cursor-pointer w-11 h-11 flex items-center justify-center text-3xl text-gray-400 hover:text-white hover:bg-gray-800 rounded-2xl transition-all">
                                        −
                                    </button>

                                    <div class="flex-1 text-center">
                                        <input type="number" wire:model.live="corners.{{ $index }}.minute"
                                            class="w-full text-4xl font-bold text-white bg-transparent text-center focus:outline-none tabular-nums">
                                        <span class="text-gray-500 text-lg">'</span>
                                    </div>

                                    <button wire:click="incrementMinute({{ $corner->id }})"
                                        class="cursor-pointer w-11 h-11 flex items-center justify-center text-3xl text-gray-400 hover:text-white hover:bg-gray-800 rounded-2xl transition-all">
                                        +
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        @endforeach

        @if ($corners->isEmpty())
            <div class="text-center py-16 text-gray-500 bg-gray-900 rounded-3xl border border-gray-800">
                Nenhum escanteio lançado ainda.<br>
                Clique em "Adicionar escanteio" para começar.
            </div>
        @endif
    </div>
</div>

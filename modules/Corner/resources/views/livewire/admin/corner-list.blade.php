<div>
    @php
        use Carbon\Carbon;
    @endphp
    {{-- <x-action-loading></x-action-loading> --}}
    <div>
        <style>
            /*!
            * Load Awesome v1.1.0 (http://github.danielcardoso.net/load-awesome/)
            * Copyright 2015 Daniel Cardoso <@DanielCardoso>
            * Licensed under MIT
            */
            .la-timer,
            .la-timer>div {
                position: relative;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }

            .la-timer {
                display: block;
                font-size: 0;
                color: #fff;
            }

            .la-timer.la-dark {
                color: #333;
            }

            .la-timer>div {
                display: inline-block;
                float: none;
                background-color: currentColor;
                border: 0 solid currentColor;
            }

            .la-timer {
                width: 32px;
                height: 32px;
            }

            .la-timer>div {
                width: 32px;
                height: 32px;
                background: transparent;
                border-width: 2px;
                border-radius: 100%;
            }

            .la-timer>div:before,
            .la-timer>div:after {
                position: absolute;
                top: 14px;
                left: 14px;
                display: block;
                width: 2px;
                margin-top: -1px;
                margin-left: -1px;
                content: "";
                background: currentColor;
                border-radius: 2px;
                -webkit-transform-origin: 1px 1px 0;
                -moz-transform-origin: 1px 1px 0;
                -ms-transform-origin: 1px 1px 0;
                -o-transform-origin: 1px 1px 0;
                transform-origin: 1px 1px 0;
                -webkit-animation: timer-loader 1250ms infinite linear;
                -moz-animation: timer-loader 1250ms infinite linear;
                -o-animation: timer-loader 1250ms infinite linear;
                animation: timer-loader 1250ms infinite linear;
                -webkit-animation-delay: -625ms;
                -moz-animation-delay: -625ms;
                -o-animation-delay: -625ms;
                animation-delay: -625ms;
            }

            .la-timer>div:before {
                height: 12px;
            }

            .la-timer>div:after {
                height: 8px;
                -webkit-animation-duration: 15s;
                -moz-animation-duration: 15s;
                -o-animation-duration: 15s;
                animation-duration: 15s;
                -webkit-animation-delay: -7.5s;
                -moz-animation-delay: -7.5s;
                -o-animation-delay: -7.5s;
                animation-delay: -7.5s;
            }

            .la-timer.la-sm {
                width: 16px;
                height: 16px;
            }

            .la-timer.la-sm>div {
                width: 16px;
                height: 16px;
                border-width: 1px;
            }

            .la-timer.la-sm>div:before,
            .la-timer.la-sm>div:after {
                top: 7px;
                left: 7px;
                width: 1px;
                margin-top: -.5px;
                margin-left: -.5px;
                border-radius: 1px;
                -webkit-transform-origin: .5px .5px 0;
                -moz-transform-origin: .5px .5px 0;
                -ms-transform-origin: .5px .5px 0;
                -o-transform-origin: .5px .5px 0;
                transform-origin: .5px .5px 0;
            }

            .la-timer.la-sm>div:before {
                height: 6px;
            }

            .la-timer.la-sm>div:after {
                height: 4px;
            }

            .la-timer.la-2x {
                width: 64px;
                height: 64px;
            }

            .la-timer.la-2x>div {
                width: 64px;
                height: 64px;
                border-width: 4px;
            }

            .la-timer.la-2x>div:before,
            .la-timer.la-2x>div:after {
                top: 28px;
                left: 28px;
                width: 4px;
                margin-top: -2px;
                margin-left: -2px;
                border-radius: 4px;
                -webkit-transform-origin: 2px 2px 0;
                -moz-transform-origin: 2px 2px 0;
                -ms-transform-origin: 2px 2px 0;
                -o-transform-origin: 2px 2px 0;
                transform-origin: 2px 2px 0;
            }

            .la-timer.la-2x>div:before {
                height: 24px;
            }

            .la-timer.la-2x>div:after {
                height: 16px;
            }

            .la-timer.la-3x {
                width: 96px;
                height: 96px;
            }

            .la-timer.la-3x>div {
                width: 96px;
                height: 96px;
                border-width: 6px;
            }

            .la-timer.la-3x>div:before,
            .la-timer.la-3x>div:after {
                top: 42px;
                left: 42px;
                width: 6px;
                margin-top: -3px;
                margin-left: -3px;
                border-radius: 6px;
                -webkit-transform-origin: 3px 3px 0;
                -moz-transform-origin: 3px 3px 0;
                -ms-transform-origin: 3px 3px 0;
                -o-transform-origin: 3px 3px 0;
                transform-origin: 3px 3px 0;
            }

            .la-timer.la-3x>div:before {
                height: 36px;
            }

            .la-timer.la-3x>div:after {
                height: 24px;
            }

            /*
            * Animation
            */
            @-webkit-keyframes timer-loader {
                0% {
                    -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }

            @-moz-keyframes timer-loader {
                0% {
                    -moz-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -moz-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }

            @-o-keyframes timer-loader {
                0% {
                    -o-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -o-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }

            @keyframes timer-loader {
                0% {
                    -webkit-transform: rotate(0deg);
                    -moz-transform: rotate(0deg);
                    -o-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    -moz-transform: rotate(360deg);
                    -o-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }

            /*!
            * Load Awesome v1.1.0 (http://github.danielcardoso.net/load-awesome/)
            * Copyright 2015 Daniel Cardoso <@DanielCardoso>
            * Licensed under MIT
            */
            .la-square-jelly-box,
            .la-square-jelly-box>div {
                position: relative;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }

            .la-square-jelly-box {
                display: block;
                font-size: 0;
                color: #fff;
            }

            .la-square-jelly-box.la-dark {
                color: #333;
            }

            .la-square-jelly-box>div {
                display: inline-block;
                float: none;
                background-color: currentColor;
                border: 0 solid currentColor;
            }

            .la-square-jelly-box {
                width: 32px;
                height: 32px;
            }

            .la-square-jelly-box>div:nth-child(1),
            .la-square-jelly-box>div:nth-child(2) {
                position: absolute;
                left: 0;
                width: 100%;
            }

            .la-square-jelly-box>div:nth-child(1) {
                top: -25%;
                z-index: 1;
                height: 100%;
                border-radius: 10%;
                -webkit-animation: square-jelly-box-animate .6s -.1s linear infinite;
                -moz-animation: square-jelly-box-animate .6s -.1s linear infinite;
                -o-animation: square-jelly-box-animate .6s -.1s linear infinite;
                animation: square-jelly-box-animate .6s -.1s linear infinite;
            }

            .la-square-jelly-box>div:nth-child(2) {
                bottom: -9%;
                height: 10%;
                background: #000;
                border-radius: 50%;
                opacity: .2;
                -webkit-animation: square-jelly-box-shadow .6s -.1s linear infinite;
                -moz-animation: square-jelly-box-shadow .6s -.1s linear infinite;
                -o-animation: square-jelly-box-shadow .6s -.1s linear infinite;
                animation: square-jelly-box-shadow .6s -.1s linear infinite;
            }

            .la-square-jelly-box.la-sm {
                width: 16px;
                height: 16px;
            }

            .la-square-jelly-box.la-2x {
                width: 64px;
                height: 64px;
            }

            .la-square-jelly-box.la-3x {
                width: 96px;
                height: 96px;
            }

            /*
            * Animations
            */
            @-webkit-keyframes square-jelly-box-animate {
                17% {
                    border-bottom-right-radius: 10%;
                }

                25% {
                    -webkit-transform: translateY(25%) rotate(22.5deg);
                    transform: translateY(25%) rotate(22.5deg);
                }

                50% {
                    border-bottom-right-radius: 100%;
                    -webkit-transform: translateY(50%) scale(1, .9) rotate(45deg);
                    transform: translateY(50%) scale(1, .9) rotate(45deg);
                }

                75% {
                    -webkit-transform: translateY(25%) rotate(67.5deg);
                    transform: translateY(25%) rotate(67.5deg);
                }

                100% {
                    -webkit-transform: translateY(0) rotate(90deg);
                    transform: translateY(0) rotate(90deg);
                }
            }

            @-moz-keyframes square-jelly-box-animate {
                17% {
                    border-bottom-right-radius: 10%;
                }

                25% {
                    -moz-transform: translateY(25%) rotate(22.5deg);
                    transform: translateY(25%) rotate(22.5deg);
                }

                50% {
                    border-bottom-right-radius: 100%;
                    -moz-transform: translateY(50%) scale(1, .9) rotate(45deg);
                    transform: translateY(50%) scale(1, .9) rotate(45deg);
                }

                75% {
                    -moz-transform: translateY(25%) rotate(67.5deg);
                    transform: translateY(25%) rotate(67.5deg);
                }

                100% {
                    -moz-transform: translateY(0) rotate(90deg);
                    transform: translateY(0) rotate(90deg);
                }
            }

            @-o-keyframes square-jelly-box-animate {
                17% {
                    border-bottom-right-radius: 10%;
                }

                25% {
                    -o-transform: translateY(25%) rotate(22.5deg);
                    transform: translateY(25%) rotate(22.5deg);
                }

                50% {
                    border-bottom-right-radius: 100%;
                    -o-transform: translateY(50%) scale(1, .9) rotate(45deg);
                    transform: translateY(50%) scale(1, .9) rotate(45deg);
                }

                75% {
                    -o-transform: translateY(25%) rotate(67.5deg);
                    transform: translateY(25%) rotate(67.5deg);
                }

                100% {
                    -o-transform: translateY(0) rotate(90deg);
                    transform: translateY(0) rotate(90deg);
                }
            }

            @keyframes square-jelly-box-animate {
                17% {
                    border-bottom-right-radius: 10%;
                }

                25% {
                    -webkit-transform: translateY(25%) rotate(22.5deg);
                    -moz-transform: translateY(25%) rotate(22.5deg);
                    -o-transform: translateY(25%) rotate(22.5deg);
                    transform: translateY(25%) rotate(22.5deg);
                }

                50% {
                    border-bottom-right-radius: 100%;
                    -webkit-transform: translateY(50%) scale(1, .9) rotate(45deg);
                    -moz-transform: translateY(50%) scale(1, .9) rotate(45deg);
                    -o-transform: translateY(50%) scale(1, .9) rotate(45deg);
                    transform: translateY(50%) scale(1, .9) rotate(45deg);
                }

                75% {
                    -webkit-transform: translateY(25%) rotate(67.5deg);
                    -moz-transform: translateY(25%) rotate(67.5deg);
                    -o-transform: translateY(25%) rotate(67.5deg);
                    transform: translateY(25%) rotate(67.5deg);
                }

                100% {
                    -webkit-transform: translateY(0) rotate(90deg);
                    -moz-transform: translateY(0) rotate(90deg);
                    -o-transform: translateY(0) rotate(90deg);
                    transform: translateY(0) rotate(90deg);
                }
            }

            @-webkit-keyframes square-jelly-box-shadow {
                50% {
                    -webkit-transform: scale(1.25, 1);
                    transform: scale(1.25, 1);
                }
            }

            @-moz-keyframes square-jelly-box-shadow {
                50% {
                    -moz-transform: scale(1.25, 1);
                    transform: scale(1.25, 1);
                }
            }

            @-o-keyframes square-jelly-box-shadow {
                50% {
                    -o-transform: scale(1.25, 1);
                    transform: scale(1.25, 1);
                }
            }

            @keyframes square-jelly-box-shadow {
                50% {
                    -webkit-transform: scale(1.25, 1);
                    -moz-transform: scale(1.25, 1);
                    -o-transform: scale(1.25, 1);
                    transform: scale(1.25, 1);
                }
            }
        </style>
        <div wire:target="getSofaScore,getCornersSofaScore"
            class="fixed w-full h-screen top-0 right-0 z-50 items-center justify-items-center
        bg-blue-900 bg-opacity-50 backdrop-brightness-50 backdrop-blur-sm "
            wire:loading>
            <div
                class="relative flex flex-col items-center max-w-lg gap-4 p-6 rounded-md top-40
            shadow-md sm:py-8 sm:px-12 bg-opacity-50 bg-blue-900 text-gray-100 mx-auto">
                <div style="color: #64d6e2" class="la-timer la-3x">
                    <div></div>
                </div>
                <h2 class="text-2xl font-semibold leadi tracki">Atualizando<span
                        class="loading loading-dots loading-xs"></span></h2>
                <div wire:model='count'>{{ $count }}</div>
                {{-- <p class="flex-1 text-center text-white">Aguarde o envio dos emails.</p> --}}
            </div>
        </div>
    </div>
    <x-layouts.breadcrumb>
        <x-slot name="left">
            <h3 class="text-2xl font-bold tracking-tight dark:text-gray-50">
                {{ $breadcrumb }}
            </h3>

        </x-slot>
        <x-slot name="center">
            <div class="flex-row ">
                <div class="flex items-center">
                    <div>
                        @if ($game->team_id)
                            @if ($game->team?->code_image)
                                <img src="{{ url('storage/teams/' . $game->team->id . '/' . $game->team->code_image . '_list.png') }}"
                                    alt="{{ $game->team->nick }}" class="w-10 h-10 object-contain">
                            @else
                                <x-application-logo width="h-14" />
                            @endif
                        @else
                            Não informado
                        @endif
                    </div>

                    <span class="badge badge-error mx-auto">VS</span>

                    <div>
                        @if ($game->opponent_id)
                            @if ($game->opponent?->code_image)
                                <img src="{{ url('storage/teams/' . $game->opponent->id . '/' . $game->opponent->code_image . '_list.png') }}"
                                    alt="{{ $game->opponent->nick }}" class="w-10 h-10 object-contain">
                            @else
                                <x-application-logo width="h-14" />
                            @endif
                        @else
                            Não informado
                        @endif
                    </div>
                </div>
                <div class="flex">
                    <span class="badge badge-primary">{{ $game->f_date }}</span>
                </div>
            </div>

        </x-slot>

        <x-slot name="right">
            <div>
                <div>
                    <div class="grid grid-cols-2 join">
                        @if ($previous)
                            <a class="join-item btn btn-outline dark:btn-info"
                                href="{{ route('corners-list', $previous->id) }}">Anterior</a>
                        @endif

                        @if ($next)
                            <a class="join-item btn btn-outline dark:btn-info"
                                href="{{ route('corners-list', $next->id) }}">Próximo</a>
                        @endif
                    </div>
                </div>
            </div>
        </x-slot>
    </x-layouts.breadcrumb>

    {{-- Botão Adicionar Novo Escanteio --}}
    <div class="flex justify-center my-8">
        <button wire:click="cleanCorners"
            class="flex items-center gap-2 px-6 py-3 text-white bg-gray-700 hover:bg-red-600 border border-gray-500 rounded-xl transition-all duration-200 font-medium">
            <span>Apagar todos escanteio</span>
            <x-layout.svg.trash class="w-5 h-5 ">
            </x-layout.svg.trash>
        </button>
        <button wire:click="addRow"
            class="flex items-center gap-2 px-6 py-3 text-white bg-gray-700 hover:bg-blue-600 border border-gray-500 rounded-xl transition-all duration-200 font-medium">
            <span>Adicionar escanteio</span>
            <x-layout.svg.plus class="w-5 h-5 ">
            </x-layout.svg.plus>
        </button>
        <button wire:click="getSofaScore"
            class="flex items-center gap-2 px-6 py-3 text-white bg-gray-700 hover:bg-blue-600 border border-gray-500 rounded-xl transition-all duration-200 font-medium">
            <span>Buscar escanteio SofaScore</span>
            <x-layout.svg.search class="w-5 h-5 ">
            </x-layout.svg.search>
        </button>
    </div>



    <div class="mt-6">
        @if (isset($this->resultado))
            <pre class="bg-gray-900 text-green-400 p-4 overflow-auto text-sm">
                {{ json_encode($this->resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
            </pre>
        @endif
    </div>

    {{-- Lista de Escanteios --}}
    <div class="mx-auto">
        @foreach ($corners as $index => $corner)
            <div class="bg-gray-900 rounded-3xl overflow-hidden border border-gray-800 shadow-xl mb-2"
                wire:key="corner-{{ $corner->id }}">

                <!-- Cabeçalho -->
                <div
                    class="px-6 py-1 text-white bg-gray-950 border-b border-gray-800 flex justify-between items-center">
                    <div class="flex justify-between pl-2 col-span-full ">
                        <div class="p-0">
                            Lançado em
                            {{ $corner->created_at ? Carbon::createFromFormat('Y-m-d H:i:s', $corner->created_at)->format('d/m/Y H:i:s') : '' }}
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
                                        {{ $corner->team?->nick ?? 'Time Casa' }}
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
                                <div class="col-span-2 text-gray-600 text-sm">
                                    {{ $corner->code }}
                                </div>
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
                                    <!-- Input com apenas os minutos -->
                                    {{-- <div class="flex-1 text-center relative">
                                        <input type="number" wire:model="{{ $corner->min }}" min="0"
                                            max="120"
                                            class="w-full text-4xl font-bold text-white bg-transparent text-center focus:outline-none tabular-nums">
                                        <span
                                            class="text-gray-500 text-lg absolute right-1/2 translate-x-1/2 bottom-1">'</span>
                                    </div> --}}
                                    <div class="flex-1 text-center">
                                        <span class="text-green-500 text-lg">
                                            {{ $corner->min }}
                                        </span>
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

<div class="max-w-7xl mx-auto px-4 flex gap-6">
    <!-- CONTEÚDO CENTRAL -->

    <x-action-loading></x-action-loading>
    <main class="flex-1">
        <x-breadcrumb>
            <x-slot name="left">
                <h3 class="text-2xl font-bold tracki dark:text-gray-50">
                    {{ $breadcrumb }}
                </h3>
            </x-slot>

        </x-breadcrumb>
        <div class="grid grid-cols-2 space-x-3 py-3 space-y-3">
            <div class="col-span-full sm:col-span-1">
                <div class="w-full h-full p-0 m-0 text-gray-900 rounded-b-md ">
                    <!-- Faltas por ano escolar -->
                    <div
                        class="p-5 shadow-md bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100 rounded-2xl">
                        <h2 class="flex items-center gap-2 mb-4 text-xl font-semibold ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" viewBox="0 0 32 32"
                                version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">

                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                                    sketch:type="MSPage">
                                    <g id="Icon-Set-Filled" sketch:type="MSLayerGroup"
                                        transform="translate(-518.000000, -153.000000)" fill="currentColor">
                                        <path
                                            d="M533,153 L533,170.3 L548.947,175.084 C549.568,173.543 550,171.688 550,169.571 C550,160.419 541.453,153 533,153 L533,153 Z M531,156 C524.029,156.728 518,163.026 518,170.5 C518,178.508 524.492,185 532.5,185 C538.397,185 543.463,181.474 545.729,176.418 L531,172 L531,156 L531,156 Z"
                                            id="pie-chart" sketch:type="MSShapeGroup">

                                        </path>
                                    </g>
                                </g>
                            </svg>
                            Média de escanteios por liga
                        </h2>
                        <div x-data="chartLeague()" x-init="init()">
                            <canvas x-ref="chart"></canvas>
                        </div>

                        <script>
                            function chartLeague() {
                                return {
                                    chart: null,
                                    labels: @json($labelsLeague),
                                    avgAll: @json($avgAllLeague),
                                    avgLast5: @json($avgLast5League),

                                    init() {

                                        console.log(this.labels); // 🔥 DEBUG

                                        if (!this.labels || this.labels.length === 0) return;

                                        this.chart = new Chart(this.$refs.chart, {
                                            type: 'bar',
                                            data: {
                                                labels: this.labels,
                                                datasets: [{
                                                        label: 'Média da Liga',
                                                        data: this.avgAll,
                                                        borderWidth: 1,
                                                        borderColor: 'rgba(59,130,246,1)',
                                                        backgroundColor: 'rgba(59,130,246,0.6)',
                                                        borderRadius: 4
                                                    },
                                                    {
                                                        label: 'Últimos 5 jogos',
                                                        data: this.avgLast5,
                                                        borderWidth: 1,
                                                        borderColor: 'rgba(234,179,8,1)',
                                                        backgroundColor: 'rgba(234,179,8,0.6)',
                                                        borderRadius: 4
                                                    }
                                                ]
                                            },
                                            options: {
                                                responsive: true,
                                                scales: {
                                                    y: {
                                                        beginAtZero: true
                                                    }
                                                }
                                            }
                                        });
                                    }
                                }
                            }
                        </script>

                    </div>
                </div>
            </div>
            <div class="col-span-full sm:col-span-1">
                <div class="w-full h-full p-0 m-0 text-gray-900 rounded-b-md ">
                    <!-- Faltas por ano escolar -->
                    <div
                        class="p-5 shadow-md bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100 rounded-2xl">
                        <h2 class="flex items-center gap-2 mb-4 text-xl font-semibold ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" viewBox="0 0 32 32"
                                version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">

                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                                    sketch:type="MSPage">
                                    <g id="Icon-Set-Filled" sketch:type="MSLayerGroup"
                                        transform="translate(-518.000000, -153.000000)" fill="currentColor">
                                        <path
                                            d="M533,153 L533,170.3 L548.947,175.084 C549.568,173.543 550,171.688 550,169.571 C550,160.419 541.453,153 533,153 L533,153 Z M531,156 C524.029,156.728 518,163.026 518,170.5 C518,178.508 524.492,185 532.5,185 C538.397,185 543.463,181.474 545.729,176.418 L531,172 L531,156 L531,156 Z"
                                            id="pie-chart" sketch:type="MSShapeGroup">

                                        </path>
                                    </g>
                                </g>
                            </svg>
                            Escanteio por tempo de jogo
                        </h2>
                        <div x-data="chartHalf()" x-init="init()">

                            <canvas x-ref="chart"></canvas>

                        </div>

                        <script>
                            window.chartHalf = function() {
                                return {
                                    chart: null,
                                    labels: @json($labelsHalf),
                                    first: @json($firstHalf),
                                    second: @json($secondHalf),

                                    init() {

                                        console.log('HALF:', this.labels);

                                        if (!this.labels || this.labels.length === 0) return;

                                        this.chart = new Chart(this.$refs.chart, {
                                            type: 'bar',
                                            data: {
                                                labels: this.labels,
                                                datasets: [{
                                                        label: '1º Tempo',
                                                        data: this.first,
                                                        borderWidth: 1,
                                                        borderColor: 'rgba(34,197,94,1)',
                                                        backgroundColor: 'rgba(34,197,94,0.6)',
                                                    },
                                                    {
                                                        label: '2º Tempo',
                                                        data: this.second,
                                                        borderWidth: 1,
                                                        borderColor: 'rgba(239,68,68,1)',
                                                        backgroundColor: 'rgba(239,68,68,0.6)',
                                                    }
                                                ]
                                            }
                                        });
                                    }
                                }
                            }
                        </script>

                    </div>



                </div>
            </div>
        </div>
        <x-table.search>

        </x-table.search>
        <x-table.table>
            <x-slot name="head">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr scope="col" class="text-gray-500 dark:text-gray-400">
                        <th scope="col" wire:click="addSort('date')"
                            class="px-4 py-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                            <x-table.table-sort-button :sorts='$sorts' field="date">
                                Data
                            </x-table.table-sort-button>
                        </th>
                        {{-- <th scope="col"
                            class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                            Campeonato
                        </th> --}}
                        <th scope="col"
                            class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                            Jogo
                        </th>

                        <th scope="col"
                            class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                            Média de escanteios
                        </th>

                        <th scope="col"
                            class="px-4 py-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                            Média 5 jogos
                        </th>
                        <th scope="col"
                            class="px-4 py-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                            Média casa
                        </th>
                        <th scope="col"
                            class="px-4 py-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                            Média Visitante
                        </th>
                        <th scope="col"
                            class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                            Previsão
                        </th>

                    </tr>
                </thead>
            </x-slot>
            <x-slot name="body">
                <tbody class="p-0 m-0 bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                    @foreach ($dataTable as $item)
                        <tr wire:click='go({{ $item->id }})' class="cursor-pointer hover:bg-gray-200">
                            <td
                                class="items-center px-4 py-1 space-x-2 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                                {{ $item->f_date }}
                            </td>
                            {{-- <td
                                class=" items-center mx-auto px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                                <div class="flex justify-center w-full mx-auto items-center ">
                                    <div class="flex ">
                                        @if ($item->championship_id)
                                            @if ($item->championship?->code_image)
                                                <img src="{{ url('storage/championships/' . $item->championship->id . '/' . $item->championship->code_image . '_list.png') }}"
                                                    alt="{{ $item->championship->nick }}"
                                                    class="w-10 h-10 object-contain">
                                            @else
                                                <x-application-logo width="h-14" />
                                            @endif
                                        @else
                                            Não informado
                                        @endif
                                    </div>
                                </div>
                            </td> --}}
                            <td
                                class="flex justify-center justify-items-center-center items-center px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                                <div class="flex items-center">
                                    <div>
                                        @if ($item->team_id)
                                            @if ($item->team?->code_image)
                                                <img src="{{ url('storage/teams/' . $item->team->id . '/' . $item->team->code_image . '_list.png') }}"
                                                    alt="{{ $item->team->nick }}" class="w-10 h-10 object-contain">
                                            @else
                                                <x-application-logo width="h-14" />
                                            @endif
                                        @else
                                            Não informado
                                        @endif
                                    </div>

                                    <span class="badge badge-error mx-auto">X</span>

                                    <div>
                                        @if ($item->opponent_id)
                                            @if ($item->opponent?->code_image)
                                                <img src="{{ url('storage/teams/' . $item->opponent->id . '/' . $item->opponent->code_image . '_list.png') }}"
                                                    alt="{{ $item->opponent->nick }}" class="w-10 h-10 object-contain">
                                            @else
                                                <x-application-logo width="h-14" />
                                            @endif
                                        @else
                                            Não informado
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td
                                class="items-center px-4 py-1 space-x-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                                {{-- <pre>
                                    @php
                                        print_r($item->stats()[0]);
                                    @endphp
                                </pre> --}}
                                <span class="badge badge-outline badge-success">
                                    {{ $item->stats()[0]['home_advanced']['home_home_avg'] }}
                                </span>
                                <span class="badge badge-outline badge-error">
                                    {{ $item->stats()[0]['away_advanced']['home_away_avg'] }}
                                </span>

                            </td>
                            <td
                                class="items-center px-4 py-1 space-x-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                                <span class="badge badge-outline badge-success">
                                    {{ $item->stats()[0]['home_advanced']['recent_avg'] }}
                                </span>
                                <span class="badge badge-outline badge-error">
                                    {{ $item->stats()[0]['away_advanced']['recent_avg'] }}
                                </span>

                            </td>
                            <td
                                class="items-center px-4 py-1 space-x-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                                <table>
                                    <tr>
                                        <td>p</td>
                                        <td>c</td>
                                    </tr>
                                    <tr>
                                        <td><span
                                                class="badge badge-outline badge-success">{{ $item->stats()[0]['home_stats']['attack'] }}</span>
                                        </td>
                                        <td><span
                                                class="badge badge-outline badge-success">{{ $item->stats()[0]['home_stats']['defense'] }}</span>
                                        </td>
                                    </tr>
                                </table>

                            </td>
                            <td
                                class=" items-center px-4 py-1 space-x-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                                <table>
                                    <tr>
                                        <td>p</td>
                                        <td>c</td>
                                    </tr>
                                    <tr>
                                        <td><span
                                                class="badge badge-outline badge-error">{{ $item->stats()[0]['away_stats']['attack'] }}</span>
                                        </td>
                                        <td><span
                                                class="badge badge-outline badge-error">{{ $item->stats()[0]['away_stats']['defense'] }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td
                                class="flex justify-center items-center px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                                <span
                                    class="badge badge-outline badge-info">{{ $item->stats()[0]['total_corners'] }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </x-slot>

            <x-slot name="link">
                {{ $dataTable->links() }}
            </x-slot>
        </x-table.table>
        {{-- MODAL READ --}}
        <x-dialog-modal wire:model="showModalShow">
            <x-slot name="title">Dados do confronto</x-slot>
            <x-slot name="content">
                <dl class="text-gray-900 divide-y divide-gray-200 max-w ">
                    @if ($detail)
                        <div class="p-4">
                            {{-- HEADER --}}
                            <div class="flex justify-between items-start mb-4">

                                <div>
                                    <h2 class="text-lg font-bold text-gray-900">
                                        &nbsp;
                                    </h2>
                                </div>

                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Nossa previsão</p>
                                    <p class="text-xl font-bold text-green-600">
                                        {{ $detail->stats()[0]['total_corners'] }}
                                    </p>
                                </div>
                            </div>

                            {{-- MATCHES --}}
                            <div class="space-y-4">
                                <div class="grid grid-cols-4 p-6">
                                    <div class="col-span-1">
                                        <div class="flex items-center mt-5">
                                            <div>
                                                @if ($detail->team_id)
                                                    @if ($detail->team?->code_image)
                                                        <img src="{{ url('storage/teams/' . $detail->team->id . '/' . $detail->team->code_image . '_list.png') }}"
                                                            alt="{{ $detail->team->nick }}"
                                                            class="w-10 h-10 object-contain">
                                                    @else
                                                        <x-application-logo width="h-14" />
                                                    @endif
                                                @else
                                                    Não informado
                                                @endif
                                            </div>

                                            <span class="badge badge-error mx-auto">X</span>

                                            <div>
                                                @if ($detail->opponent_id)
                                                    @if ($detail->opponent?->code_image)
                                                        <img src="{{ url('storage/teams/' . $detail->opponent->id . '/' . $detail->opponent->code_image . '_list.png') }}"
                                                            alt="{{ $detail->opponent->nick }}"
                                                            class="w-10 h-10 object-contain">
                                                    @else
                                                        <x-application-logo width="h-14" />
                                                    @endif
                                                @else
                                                    Não informado
                                                @endif
                                            </div>
                                        </div>
                                        <div class="p-4 text-center mt-10">
                                            <p class="text-xs text-gray-500">último confronto</p>
                                            <p class="text-2xl font-bold ">
                                                <span class="badge badge-outline badge-success">
                                                    {{ $detail->last()->corners_visitor() }}
                                                </span>
                                                <span class="badge badge-outline badge-error">
                                                    {{ $detail->last()->corners_home() }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-span-3">
                                        <div class=" grid grid-cols-2 gap-4 mb-6">
                                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                                <p class="text-xs text-gray-500">Média geral</p>
                                                <p class="text-2xl font-bold ">
                                                    <span class="badge badge-outline badge-success">
                                                        {{ $item->stats()[0]['home_advanced']['home_home_avg'] }}
                                                    </span>
                                                    <span class="badge badge-outline badge-error">
                                                        {{ $item->stats()[0]['away_advanced']['home_away_avg'] }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                                <p class="text-xs text-gray-500">Média 5 jogos</p>
                                                <p class="text-2xl font-bold ">
                                                    <span class="badge badge-outline badge-success">
                                                        {{ $item->stats()[0]['home_advanced']['recent_avg'] }}
                                                    </span>
                                                    <span class="badge badge-outline badge-error">
                                                        {{ $item->stats()[0]['away_advanced']['recent_avg'] }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4 mb-6">
                                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                                <p class="text-xs text-gray-500">Time da casa</p>
                                                <p class="text-2xl font-bold ">
                                                <table class="w-full text-center mx-auto">
                                                    <tr>
                                                        <td>pró</td>
                                                        <td>contra</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span
                                                                class="badge badge-outline badge-success">{{ $item->stats()[0]['home_stats']['attack'] }}</span>
                                                        </td>
                                                        <td><span
                                                                class="badge badge-outline badge-success">{{ $item->stats()[0]['home_stats']['defense'] }}</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                                </p>
                                            </div>
                                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                                <p class="text-xs text-gray-500">Visitante</p>
                                                <p class="text-2xl font-bold ">
                                                <table class="w-full text-center mx-auto">
                                                    <tr>
                                                        <td>pró</td>
                                                        <td>contra</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span
                                                                class="badge badge-outline badge-error">{{ $item->stats()[0]['away_stats']['attack'] }}</span>
                                                        </td>
                                                        <td><span
                                                                class="badge badge-outline badge-error">{{ $item->stats()[0]['away_stats']['defense'] }}</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </dl>
            </x-slot>
            <x-slot name="footer">

                <x-secondary-button wire:click="$toggle('showModalShow')" class="mx-2">
                    Fechar
                </x-secondary-button>
            </x-slot>
        </x-dialog-modal>
    </main>


    <!-- SIDEBAR DIREITA -->
    <aside class="hidden xl:block w-64 space-y-4">

        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow text-center">
            <p class="text-sm text-gray-500">Publicidade</p>
            <div class="h-40 bg-gray-200 dark:bg-gray-700 rounded mt-2">

            </div>
        </div>


        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow text-center">
            <p class="text-sm text-gray-500">Publicidade</p>
            <div class="h-40 bg-gray-200 dark:bg-gray-700 rounded mt-2"></div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow text-center">
            <p class="text-sm text-gray-500">Publicidade</p>
            <div class="h-40 bg-gray-200 dark:bg-gray-700 rounded mt-2"></div>
        </div>

    </aside>
</div>

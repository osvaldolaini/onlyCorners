@php
    use Carbon\Carbon;
    use App\Enums\CornerMarketLabel;
@endphp
<div class="max-w-7xl mx-auto px-4 flex gap-6">
    <!-- CONTEÚDO CENTRAL -->
    <main class="flex-1">
        <x-breadcrumb>
            <x-slot name="left">
                <h3 class="text-2xl font-bold tracki dark:text-gray-50">
                    {{ $breadcrumb }}
                </h3>
            </x-slot>
        </x-breadcrumb>
        <div class="grid grid-cols-2 space-x-3 py-3">
            <div class="col-span-full sm:col-span-1">
                <div class="p-5 shadow-md bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100 rounded-2xl">

                    <!-- Faltas por ano escolar -->

                    <h2 class="flex items-center gap-2 mb-4 text-xl font-semibold ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" viewBox="0 0 32 32"
                            version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
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
                        Vitória / Derrotas (Under)
                    </h2>
                    <div x-data='{
                            labels: @json($labelsUnder),
                            wins: @json($winsUnder),
                            losses: @json($lossesUnder)
                        }'
                        x-init="new Chart($refs.chart_under, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                        label: 'Wins',
                                        data: wins,
                                        backgroundColor: 'rgba(34,197,94,0.6)'
                                    },
                                    {
                                        label: 'Losses',
                                        data: losses,
                                        backgroundColor: 'rgba(239,68,68,0.6)'
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: { beginAtZero: true }
                                }
                            }
                        })">

                        <canvas x-ref="chart_under"></canvas>
                    </div>

                </div>
            </div>
            <div class="col-span-full sm:col-span-1">

                <!-- Faltas por ano escolar -->
                <div class="p-5 shadow-md bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100 rounded-2xl">
                    <h2 class="flex items-center gap-2 mb-4 text-xl font-semibold ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" viewBox="0 0 32 32"
                            version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
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
                        Vitória / Derrotas (Over)
                    </h2>
                    <div x-data='{
                            labels: @json($labelsOver),
                            wins: @json($winsOver),
                            losses: @json($lossesOver)
                        }'
                        x-init="new Chart($refs.chart_over, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                        label: 'Wins',
                                        data: wins,
                                        backgroundColor: 'rgba(34,197,94,0.6)'
                                    },
                                    {
                                        label: 'Losses',
                                        data: losses,
                                        backgroundColor: 'rgba(239,68,68,0.6)'
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: { beginAtZero: true }
                                }
                            }
                        })">

                        <canvas x-ref="chart_over"></canvas>
                    </div>

                </div>

            </div>
            <div class="col-span-2 mt-3 mr-2">
                <div class="p-5 bg-white dark:bg-gray-700 rounded-2xl shadow-md">

                    <h2 class="mb-4 text-xl font-semibold">
                        Performance por Mercado
                    </h2>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left border border-gray-200 dark:border-gray-600">

                            <thead class="bg-gray-100 dark:bg-gray-800">
                                <tr>
                                    <th class="px-4 py-2">Mercado</th>
                                    <th class="px-4 py-2 text-green-600">Win</th>
                                    <th class="px-4 py-2 text-red-600">Loss</th>
                                    <th class="px-4 py-2 text-yellow-500">Taxa</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($tableMarkets as $row)
                                    <tr class="border-t dark:border-gray-600">

                                        <td class="px-4 py-2 font-semibold">
                                            {{ $row['market'] }}
                                        </td>

                                        <td class="px-4 py-2 text-green-500 font-bold">
                                            {{ $row['wins'] }}
                                        </td>

                                        <td class="px-4 py-2 text-red-500 font-bold">
                                            {{ $row['losses'] }}
                                        </td>

                                        <td class="px-4 py-2 font-bold">
                                            {{ $row['rate'] }}%
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>

    </main>
    <!-- SIDEBAR DIREITA -->
    <aside class="hidden xl:block w-64 space-y-4">

        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow text-center">
            <p class="text-sm text-gray-500">Publicidade</p>
            <div class="h-40 bg-gray-200 dark:bg-gray-700 rounded mt-2"></div>
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

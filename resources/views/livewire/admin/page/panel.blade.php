<div class="pt-3 w-full sm:rounded-lg">
    <div class="grid w-full grid-cols-6 gap-2">
        <a href="{{ route('teams-list') }}" class="col-span-full sm:col-span-1">
            <div class="relative h-32 overflow-hidden bg-blue-500 rounded-lg shadow-md">
                <x-layout.svg.shield
                    class="absolute w-24 h-24 text-blue-800 rounded-md opacity-50 -top-3 -right-6 md:-right-6">
                </x-layout.svg.shield>
                <div class="p-4 ">
                    <dl>
                        <dt class="text-sm font-medium leading-5 text-white truncate">
                            Clubes
                        </dt>
                        <dd class="mt-1 text-5xl font-bold leading-9 text-white">
                            {{ $teams }}
                        </dd>
                    </dl>
                </div>
            </div>
        </a>
        <a href="{{ route('championships-list') }}" class="col-span-full sm:col-span-1">
            <div class="relative h-32 overflow-hidden bg-blue-500 rounded-lg shadow-md">
                <x-layout.svg.trophy
                    class="absolute w-24 h-24 text-blue-800 rounded-md opacity-50 -top-3 -right-6 md:-right-6">
                </x-layout.svg.trophy>
                <div class="p-4 ">
                    <dl>
                        <dt class="text-sm font-medium leading-5 text-white truncate">
                            Campeonatos
                        </dt>
                        <dd class="mt-1 text-5xl font-bold leading-9 text-white">
                            {{ $championships }}
                        </dd>
                    </dl>
                </div>
            </div>
        </a>
        <div class="col-span-full sm:col-span-4"></div>
        <div class="col-span-full sm:col-span-3">
            <div class="w-full h-full p-0 m-0 text-gray-900 rounded-b-md ">
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
                        Vitórias vs Derrotas
                    </h2>
                    <div class="w-full h-full px-1">
                        <div class="bg-white w-full h-full">
                            <div class="px-2 py-2 h-full">

                                <div x-data='{
                                    labels: @json($labels),
                                    wins: @json($wins),
                                    losses: @json($losses)
                                }'
                                    x-init="new Chart($refs.chart, {
                                        type: 'bar',
                                        data: {
                                            labels: labels,
                                            datasets: [{
                                                    label: 'Vitórias',
                                                    data: wins,
                                                    borderWidth: 1,
                                                    borderColor: 'rgba(34,197,94,1)',
                                                    backgroundColor: 'rgba(34,197,94,0.6)',
                                                    borderRadius: 4
                                                },
                                                {
                                                    label: 'Derrotas',
                                                    data: losses,
                                                    borderWidth: 1,
                                                    borderColor: 'rgba(239,68,68,1)',
                                                    backgroundColor: 'rgba(239,68,68,0.6)',
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
                                    })">

                                    <canvas x-ref="chart"></canvas>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>



            </div>
        </div>
        <div class="col-span-full sm:col-span-3">
            <div class="w-full h-full p-0 m-0 text-gray-900 rounded-b-md ">
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
                        Vitórias vs Derrotas (Mês)
                    </h2>
                    <div class="w-full h-full px-1">
                        <div class="bg-white w-full h-full">
                            <div class="px-2 py-2 h-full">

                                <div x-data='{
                                    labels: @json($labelsMonth),
                                    wins: @json($winsMonth),
                                    losses: @json($lossesMonth)
                                }'
                                    x-init="new Chart($refs.chart_month, {
                                        type: 'bar',
                                        data: {
                                            labels: labels,
                                            datasets: [{
                                                    label: 'Vitórias',
                                                    data: wins,
                                                    borderWidth: 1,
                                                    borderColor: 'rgba(34,197,94,1)',
                                                    backgroundColor: 'rgba(34,197,94,0.6)',
                                                    borderRadius: 4
                                                },
                                                {
                                                    label: 'Derrotas',
                                                    data: losses,
                                                    borderWidth: 1,
                                                    borderColor: 'rgba(239,68,68,1)',
                                                    backgroundColor: 'rgba(239,68,68,0.6)',
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
                                    })">

                                    <canvas x-ref="chart_month"></canvas>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>



            </div>
        </div>

    </div>
</div>

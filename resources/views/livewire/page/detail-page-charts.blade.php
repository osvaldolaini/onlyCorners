<div class="grid grid-cols-2 space-x-3 px-3">

    <div class="col-span-full sm:col-span-1">
        <div class="w-full h-full p-0 m-0 text-gray-900 rounded-b-md ">
            <!-- Faltas por ano escolar -->
            <div class="p-5 shadow-md bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100 rounded-2xl">
                <h2 class="flex items-center gap-2 mb-4 text-xl font-semibold ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" viewBox="0 0 32 32" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
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

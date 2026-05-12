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
        <div class="grid grid-cols-2 space-x-3 py-3 space-y-3">

            <div class="col-span-full sm:col-span-1">
                <div class=" p-0 m-0 my-3 text-gray-900 rounded-b-md ">
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
                            Vitórias vs Derrotas
                        </h2>
                        <div class=" px-1">
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
            <div class="col-span-full sm:col-span-1">
                <div class=" p-0 m-0 my-3 text-gray-900 rounded-b-md ">
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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            @foreach ($cards as $card)
                @php
                    $border = 'border-yellow-500';
                @endphp
                @switch($card['type'])
                    @case('safe')
                        @php
                            $border = 'border-green-500';
                        @endphp
                    @break

                    @case('medium')
                        @php
                            $border = 'border-yellow-500';
                        @endphp
                    @break

                    @case('aggressive')
                        @php
                            $border = 'border-red-500';
                        @endphp
                    @break

                    @php
                        $border = 'border-yellow-500';
                    @endphp

                    @default
                @endswitch
                @switch($card['status'])
                    @case('won')
                        @php
                            $bg = 'bg-green-400';
                        @endphp
                    @break

                    @case('lost')
                        @php
                            $bg = 'bg-red-400';
                        @endphp
                    @break

                    @php
                        $bg = 'bg-white';
                    @endphp

                    @default
                @endswitch
                <div
                    class="border-2 {{ $border }} rounded-2xl p-6 shadow-lg {{ $bg }} hover:shadow-xl transition">

                    {{-- 🔹 HEADER --}}
                    <div class="flex justify-between items-center mb-5">

                        <div>
                            <h2 class="text-xl font-bold capitalize">
                                {{ $card['type'] }}
                            </h2>
                            <p class="text-xs text-gray-50">
                                {{ $card['total_matches'] }} jogos
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="cursor-pointer px-3 py-1 text-xs rounded bg-gray-100 hover:bg-gray-200"
                                wire:click='showModal({{ $card['id'] }})'>
                                Detalhes
                            </span>
                        </div>

                    </div>

                    {{-- 🔹 ODD / PROB EM DESTAQUE --}}
                    <div class="grid grid-cols-2 gap-4 mb-6">

                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <p class="text-xs text-gray-500">Odd Total</p>
                            <p class="text-2xl font-bold text-green-600">
                                {{ number_format($card['total_odds'], 2) }}
                            </p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <p class="text-xs text-gray-500">Probabilidade</p>
                            <p class="text-2xl font-bold text-blue-600">
                                {{ number_format($card['total_prob'] * 100, 1) }}%
                            </p>
                        </div>

                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        @php
                            $validation = json_decode($card['validation'], true);
                        @endphp
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <p class="text-xs text-gray-500">Acertos</p>
                            <p class="text-2xl font-bold text-green-600">
                                {{ $validation['hits'] ?? 0 }}
                            </p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <p class="text-xs text-gray-500">Erros</p>
                            <p class="text-2xl font-bold text-red-600">
                                {{ $validation['misses'] ?? 0 }}
                            </p>
                        </div>

                    </div>



                </div>
            @endforeach

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
    {{-- MODAL READ --}}
    <x-dialog-modal wire:model="showModalShow">
        <x-slot name="title">Detalhes</x-slot>
        <x-slot name="content">
            <dl class="text-gray-900 divide-y divide-gray-200 max-w ">
                @if ($detail)
                    @php
                        $border = 'border-yellow-500';
                    @endphp
                    @switch($detail['type'])
                        @case('safe')
                            @php
                                $border = 'border-green-500';
                            @endphp
                        @break

                        @case('medium')
                            @php
                                $border = 'border-yellow-500';
                            @endphp
                        @break

                        @case('aggressive')
                            @php
                                $border = 'border-red-500';
                            @endphp
                        @break

                        @php
                            $border = 'border-yellow-500';
                        @endphp

                        @default
                    @endswitch
                    @switch($card['status'])
                        @case('won')
                            @php
                                $bg = 'bg-green-300';
                            @endphp
                        @break

                        @case('lost')
                            @php
                                $bg = 'bg-red-300';
                            @endphp
                        @break

                        @php
                            $bg = 'bg-white';
                        @endphp

                        @default
                    @endswitch
                    <div
                        class="border-2 {{ $border }} rounded-2xl p-6 shadow-lg {{ $bg }} hover:shadow-xl transition">

                        {{-- 🔹 HEADER --}}
                        <div class="flex justify-between items-center mb-5">

                            <div>
                                <h2 class="text-xl font-bold capitalize">
                                    {{ $detail['type'] }}
                                </h2>
                                <p class="text-xs text-gray-500">
                                    {{ $detail['total_matches'] }} jogos
                                </p>
                            </div>

                        </div>

                        {{-- 🔹 ODD / PROB EM DESTAQUE --}}
                        <div class="grid grid-cols-2 gap-4 mb-6">

                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                <p class="text-xs text-gray-500">Odd Total</p>
                                <p class="text-2xl font-bold text-green-600">
                                    {{ number_format($detail['total_odds'], 2) }}
                                </p>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                <p class="text-xs text-gray-500">Probabilidade</p>
                                <p class="text-2xl font-bold text-blue-600">
                                    {{ number_format($detail['total_prob'] * 100, 1) }}%
                                </p>
                            </div>

                        </div>

                        {{-- 🔹 MATCHES --}}
                        <div class="space-y-4">

                            @foreach (json_decode($detail['matches'], true) as $match)
                                <div
                                    class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition">

                                    {{-- HEADER MATCH --}}
                                    <div class="flex justify-between items-center mb-3">

                                        <div class="text-xs text-gray-500">
                                            Jogo #{{ $match['game_id'] }}
                                        </div>

                                        @if (isset($match['won']))
                                            <span
                                                class="text-xs px-3 py-1 rounded-full
                                        {{ $match['won'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $match['won'] ? 'WIN' : 'LOSS' }}
                                            </span>
                                        @else
                                            <span class="text-xs px-3 py-1 rounded-full bg-yellow-100 text-yellow-700">
                                                PENDING
                                            </span>
                                        @endif

                                    </div>

                                    {{-- TIMES --}}
                                    <div class="text-base font-semibold text-gray-800 mb-4">
                                        {{ $match['home_team'] }}
                                        <span class="text-gray-400 mx-2">vs</span>
                                        {{ $match['away_team'] }}
                                    </div>

                                    {{-- INFO --}}
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">

                                        <div>
                                            <p class="text-gray-500">Aposta</p>
                                            <p class="font-semibold text-blue-600">
                                                {{ CornerMarketLabel::from($match['type'])->label() }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-gray-500">Odd</p>
                                            <p class="font-semibold text-green-600">
                                                {{ number_format($match['odd'], 2) }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-gray-500">Prob</p>
                                            <p class="font-semibold">
                                                {{ number_format($match['probability'] * 100, 1) }}%
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-gray-500">Previsão</p>
                                            <p class="font-semibold">
                                                {{ $match['total_corners'] ?? '-' }}
                                            </p>
                                        </div>

                                    </div>

                                    {{-- RESULTADO --}}
                                    <div class="mt-4 text-sm">
                                        <span class="text-gray-500">Escanteios do jogo:</span>
                                        <span class="font-bold text-gray-800 ml-1">
                                            {{ $match['result_corners'] ?? '-' }}
                                        </span>
                                    </div>

                                </div>
                            @endforeach

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
</div>

<div>
    @php
        use App\Enums\CardLevelLabel;
    @endphp
    <!-- CONTENT -->
    @php
        $betsFormatted = collect($bets)->map(function ($bet) {
            return [
                'id' => $bet['id'],
                'risk' => $bet['type'],
                'code' => $bet['code'],
                'total_odd' => $bet['total_odds'],
                'probability' => round($bet['total_prob'] * 100),
                'games' => json_decode($bet['matches'], true) ?? [],
            ];
        });
    @endphp

    <div class="max-w-7xl mx-auto px-4 flex gap-6">
        <!-- SIDEBAR ESQUERDA -->
        <aside class="hidden xl:block w-64 space-y-4">

            <div class=" dark:bg-gray-800 p-4 rounded-xl shadow">
                <h3 class="font-bold mb-2 text-gray-100 dark:text-white">
                    Filtros
                </h3>

                <ul class="text-sm space-y-2 text-gray-600 dark:text-gray-300">

                    <li wire:click="toggleRisk('safe')"
                        class="cursor-pointer flex items-center justify-between p-2 rounded-lg transition
                        {{ in_array('safe', $risks) ? 'bg-green-100 dark:bg-green-900/30' : 'text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">

                        <span>Conservador</span>

                        @if (in_array('safe', $risks))
                            <span class="text-green-500 font-bold">✔</span>
                        @endif
                    </li>

                    <li wire:click="toggleRisk('medium')"
                        class="cursor-pointer flex items-center justify-between p-2 rounded-lg transition
                        {{ in_array('medium', $risks) ? 'bg-yellow-100 dark:bg-yellow-900/30' : 'text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">

                        <span>Moderado</span>

                        @if (in_array('medium', $risks))
                            <span class="text-yellow-500 font-bold">✔</span>
                        @endif
                    </li>

                    <li wire:click="toggleRisk('aggressive')"
                        class="cursor-pointer flex items-center justify-between p-2 rounded-lg transition
                        {{ in_array('aggressive', $risks) ? 'bg-red-100 dark:bg-red-900/30' : 'text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">

                        <span>Agressivo</span>

                        @if (in_array('aggressive', $risks))
                            <span class="text-red-500 font-bold">✔</span>
                        @endif
                    </li>

                </ul>
            </div>

            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow text-center">
                <p class="text-sm text-gray-500">Publicidade</p>
                <div class="h-40 bg-gray-200 dark:bg-gray-700 rounded mt-2"></div>
            </div>

        </aside>


        <!-- CONTEÚDO CENTRAL -->
        <main class="flex-1">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                @foreach ($betsFormatted as $bet)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow hover:shadow-md transition
                    border-l-4
                    {{ $bet['risk'] == 'safe' ? 'border-green-500' : '' }}
                    {{ $bet['risk'] == 'medium' ? 'border-yellow-500' : '' }}
                    {{ $bet['risk'] == 'aggressive' ? 'border-red-500' : '' }}
                ">

                        <!-- HEADER -->
                        <div class="flex justify-between items-center mb-3">

                            <div>
                                <h2 class="text-sm font-bold text-gray-800 dark:text-white uppercase">
                                    {{ CardLevelLabel::from($bet['risk'])->label() }}
                                </h2>
                                <p class="text-xs text-gray-500">
                                    {{ count($bet['games']) }} jogos
                                </p>
                            </div>

                            <button wire:click="showModal({{ $bet['id'] }})"
                                class="cursor-pointer text-xs px-2 py-1 bg-blue-300 dark:bg-gray-700 rounded">
                                Ver
                            </button>

                        </div>

                        <!-- STATS -->
                        <div class="flex justify-between text-sm mb-3">

                            <div>
                                <p class="text-gray-500 text-xs">Odd</p>
                                <p class="text-green-600 font-bold">
                                    {{ $bet['total_odd'] }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500 text-xs">Prob</p>
                                <p class="text-blue-600 font-bold">
                                    {{ $bet['probability'] }}%
                                </p>
                            </div>

                        </div>

                        <!-- JOGOS (compacto) -->
                        <div class="space-y-1 text-xs">

                            @foreach (array_slice($bet['games'], 0, 5) as $game)
                                <div class="flex justify-between items-center text-gray-700 dark:text-gray-300">

                                    <div class="flex flex-col truncate max-w-[60%]">
                                        <span class="truncate text-sm font-medium">
                                            {{ $game['home_team'] }}
                                            <span class="text-gray-400 mx-1">vs</span>
                                            {{ $game['away_team'] }}
                                        </span>

                                        <span class="text-xs text-blue-600 dark:text-blue-400">
                                            {{ \App\Enums\CornerMarketLabel::from($game['type'])->label() }}
                                            (Previsão {{ $game['total_corners'] }} escanteios)
                                        </span>
                                    </div>

                                    <div class="text-right">
                                        <span class="text-sm font-bold text-green-600">
                                            {{ $game['odd'] }}
                                        </span>
                                    </div>

                                </div>
                            @endforeach

                            @if (count($bet['games']) > 5)
                                <p class="text-gray-400 text-xs mt-1">
                                    +{{ count($bet['games']) - 5 }} jogos
                                </p>
                            @endif

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
                <p class="text-sm text-gray-500">Destaque</p>
                <div class="h-40 bg-gray-200 dark:bg-gray-700 rounded mt-2"></div>
            </div>

        </aside>

    </div>
    {{-- MODAL READ --}}
    <x-dialog-modal wire:model="showModalShow">
        <x-slot name="title">Detalhes</x-slot>
        <x-slot name="content">
            <dl class="text-gray-900 divide-y divide-gray-200 max-w ">
                @if ($detail)
                    <div class="p-4">

                        {{-- HEADER --}}
                        <div class="flex justify-between items-start mb-4">

                            <div>
                                <h2 class="text-lg font-bold text-gray-50">
                                    Card {{ $detail->code }}
                                </h2>

                                <p class="text-sm text-gray-500">
                                    Tipo:
                                    <span class="font-semibold uppercase">
                                        {{ CardLevelLabel::from($detail->type)->label() }}
                                    </span>
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-sm text-gray-500">Odd Total</p>
                                <p class="text-xl font-bold text-green-600">
                                    {{ number_format($detail->total_odds, 2) }}
                                </p>
                            </div>

                        </div>

                        {{-- STATUS --}}
                        <div class="mb-4">
                            <span
                                class="px-3 py-1 text-xs rounded-full
                      bg-yellow-100 text-yellow-700 
                        ">
                                Aguardando jogo
                            </span>
                        </div>

                        {{-- MATCHES --}}
                        <div class="space-y-4">

                            @foreach (json_decode($detail->matches, true) as $match)
                                <div class="border rounded-lg p-4 bg-gray-50">

                                    {{-- HEADER DO JOGO --}}
                                    <div class="flex justify-between items-center mb-3">

                                        <div class="font-semibold">
                                            {{ $match['home_team'] ?? 'Home' }}
                                            <span class="text-gray-400">vs</span>
                                            {{ $match['away_team'] ?? 'Away' }}
                                        </div>


                                    </div>

                                    {{-- DADOS PRINCIPAIS --}}
                                    <div class="grid grid-cols-3 gap-3 text-sm mb-3">

                                        <div>
                                            <p class="text-gray-500">Previsão</p>
                                            <p class="font-bold">
                                                {{ $match['total_corners'] ?? '-' }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-gray-500">Aposta</p>
                                            <p class="font-bold text-blue-600 uppercase">
                                                {{ \App\Enums\CornerMarketLabel::from($match['type'])->label() }}
                                                {{-- {{ str_replace('_', ' ', $match['bet'] ?? ($match['type'] ?? '-')) }} --}}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-gray-500">Odd</p>
                                            <p class="font-bold text-green-600">
                                                {{ $match['odd'] ?? '-' }}
                                            </p>
                                        </div>

                                    </div>

                                    {{-- RESULTADO --}}
                                    @isset($match['result_corners'])
                                        <div class="text-sm mb-2">
                                            <span class="text-gray-500">Escanteios:</span>
                                            <span class="font-bold">
                                                {{ $match['result_corners'] }}
                                            </span>
                                        </div>
                                    @endisset

                                    {{-- EXPLICAÇÃO --}}
                                    @isset($match['explanation'])
                                        <div class="text-xs text-gray-600 bg-white p-2 rounded border leading-relaxed">
                                            {{ $match['explanation'] }}
                                        </div>
                                    @endisset

                                </div>
                            @endforeach

                        </div>

                    </div>
                @endif
            </dl>
        </x-slot>
        <x-slot name="footer">
            @if ($detail)
                <button wire:click='go({{ $detail->id }})'
                    class='cursor-pointer inline-flex items-center px-4 py-2 bg-white dark:bg-blue-800 border border-blue-300 dark:border-blue-500 rounded-md font-semibold text-xs text-blue-700 dark:text-blue-300 uppercase tracking-widest shadow-sm hover:bg-blue-50 dark:hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-blue-800 disabled:opacity-25 transition ease-in-out duration-150'>
                    Avaliação completa
                </button>
            @endif
            <x-secondary-button wire:click="$toggle('showModalShow')" class="mx-2">
                Fechar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>

</div>

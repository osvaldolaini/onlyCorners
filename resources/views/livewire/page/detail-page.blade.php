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

    </div>


</div>

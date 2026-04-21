<div>
    @php
        use Carbon\Carbon;
        use App\Enums\CornerMarketLabel;
    @endphp
    <x-layouts.breadcrumb>
        <x-slot name="left">
            <h3 class="text-2xl font-bold tracking-tight dark:text-gray-50">
                {{ $breadcrumb }}
            </h3>
        </x-slot>
    </x-layouts.breadcrumb>

    {{-- Botão Adicionar Novo Escanteio --}}
    <div class="grid grid-cols-3">
        <div class="flex justify-center my-8">
            <a href="{{ route('prediction-history') }}"
                class="flex items-center gap-2 px-6 py-3 text-white bg-gray-700 hover:bg-blue-600 border border-gray-500 rounded-xl transition-all duration-200 font-medium">
                <span>Histórico</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>
        <div class="flex justify-center my-8">
            <button wire:click="generatePredictions"
                class="flex items-center gap-2 px-6 py-3 text-white bg-gray-700 hover:bg-blue-600 border border-gray-500 rounded-xl transition-all duration-200 font-medium">
                <span>Gerar previsão</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>
        <div class="flex justify-center my-8">
            <button wire:click="checkResults"
                class="flex items-center gap-2 px-6 py-3 text-white bg-gray-700 hover:bg-blue-600 border border-gray-500 rounded-xl transition-all duration-200 font-medium">
                <span>Verificar previsão</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @foreach ($cards as $card)
            @php
                $border = match ($card['type']) {
                    'safe' => 'border-green-500',
                    'medium' => 'border-yellow-500',
                    'aggressive' => 'border-red-500',
                    default => 'border-gray-300',
                };
            @endphp

            <div class="border-2 {{ $border }} rounded-2xl p-6 shadow-lg bg-white hover:shadow-xl transition">

                {{-- 🔹 HEADER --}}
                <div class="flex justify-between items-start mb-5">

                    <div>
                        <h2 class="text-xl font-bold capitalize">
                            {{ $card['type'] }}
                        </h2>
                        <p class="text-xs text-gray-500">
                            {{ $card['total_matches'] }} jogos
                        </p>
                    </div>

                    <button wire:click='showModal({{ $card['id'] }})'
                        class="text-xs px-3 py-1 rounded bg-gray-100 hover:bg-gray-200 transition">
                        Detalhes
                    </button>

                </div>

                {{-- 🔹 ODD / PROB --}}
                <div class="grid grid-cols-2 gap-4 mb-6">

                    <div class="bg-gray-200 rounded-xl p-4 text-center">
                        <p class="text-xs text-gray-500">Odd Total</p>
                        <p class="text-2xl font-bold text-green-600">
                            {{ number_format($card['total_odds'], 2) }}
                        </p>
                    </div>

                    <div class="bg-gray-200 rounded-xl p-4 text-center">
                        <p class="text-xs text-gray-500">Probabilidade</p>
                        <p class="text-2xl font-bold text-blue-600">
                            {{ number_format($card['total_prob'] * 100, 1) }}%
                        </p>
                    </div>

                </div>

                {{-- 🔹 MATCHES --}}
                <div class="space-y-4">

                    @foreach (json_decode($card['matches'], true) as $match)
                        <div class="bg-gray-200 border border-gray-100 rounded-xl p-4 hover:bg-gray-100 transition">

                            {{-- HEADER MATCH --}}
                            <div class="flex justify-between items-center mb-2">

                                <div class="text-xs text-gray-500">
                                    Jogo #{{ $match['game_id'] }}
                                </div>

                            </div>

                            {{-- TIMES --}}
                            <div class="font-semibold text-gray-800 mb-3">
                                {{ $match['home_team'] }}
                                <span class="text-gray-400 mx-1">vs</span>
                                {{ $match['away_team'] }}
                            </div>

                            {{-- INFO --}}
                            <div class="grid grid-cols-2 gap-3 text-sm">

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

                        </div>
                    @endforeach

                </div>

            </div>
        @endforeach

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
                                        {{ $detail->type }}
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
                            @if ($detail->status == 'won') bg-green-100 text-green-700
                            @elseif($detail->status == 'lost') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700 @endif
                        ">
                                {{ strtoupper($detail->status) }}
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

                                        @if (isset($match['won']))
                                            <span
                                                class="text-xs px-2 py-1 rounded
                                            {{ $match['won'] ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                                {{ $match['won'] ? 'GREEN' : 'RED' }}
                                            </span>
                                        @endif

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
                                                {{ str_replace('_', ' ', $match['bet'] ?? ($match['type'] ?? '-')) }}
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
            <x-secondary-button wire:click="$toggle('showModalShow')" class="mx-2">
                Fechar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>

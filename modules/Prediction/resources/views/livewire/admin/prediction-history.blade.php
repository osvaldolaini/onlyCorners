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
                                        <span class="text-gray-500">Escanteios reais:</span>
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

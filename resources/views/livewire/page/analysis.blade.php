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

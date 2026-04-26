<div class="max-w-7xl mx-auto px-4 flex gap-6">
    <!-- CONTEÚDO CENTRAL -->
    <main class="flex-1">
        <x-breadcrumb>
            <x-slot name="left">
                <h3 class="text-2xl font-bold tracki dark:text-gray-50">
                    {{ $breadcrumb }}
                </h3>
            </x-slot>
            <x-slot name="right">
                <div class="p-0 tooltip tooltip-top" data-tip="Planilha de dados em .xlxs" wire:ignore>
                    <button wire:click="get_data()"
                        class="cursor-pointer px-3 py-2 transition-colors duration-200 rounded-sm hover:text-white dark:hover:bg-blue-500 hover:bg-blue-500 whitespace-nowrap">
                        <x-layout.svg.excel class="w-6 h-6"></x-layout.svg.excel>
                    </button>
                </div>
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
                        <th scope="col"
                            class="px-4 py-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                            Minuto
                        </th>
                        <th scope="col"
                            class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                            Favorecido
                        </th>
                        <th scope="col"
                            class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                            Campeonato
                        </th>
                        <th scope="col"
                            class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                            Jogo
                        </th>
                        <th scope="col"
                            class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                            Tempo
                        </th>
                    </tr>
                </thead>
            </x-slot>
            <x-slot name="body">
                <tbody class="p-0 m-0 bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                    @foreach ($dataTable as $item)
                        <tr>
                            <td
                                class="items-center px-4 py-1 space-x-2 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                                {{ $item->f_date }}
                            </td>
                            <td
                                class="items-center px-4 py-1 space-x-2 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                                {{ $item->min ?? 'Não informado' }}
                            </td>
                            <td
                                class="flex justify-center items-center px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                                @if ($item->favored_id)
                                    @if ($item->favored?->code_image)
                                        <img src="{{ url('storage/teams/' . $item->favored->id . '/' . $item->favored->code_image . '_list.png') }}"
                                            alt="{{ $item->favored->nick }}" class="w-10 h-10 object-contain">
                                    @else
                                        <x-application-logo width="h-14" />
                                    @endif
                                @else
                                    Não informado
                                @endif

                            </td>
                            <td
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


                            </td>
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

                                    <span class="badge badge-error mx-auto">VS</span>

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
                            <td class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                                {{ $item->half ? ($item->half == 'first' ? '1º Tempo' : '2º Tempo') : 'Não informado' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </x-slot>

            <x-slot name="link">
                {{ $dataTable->links() }}
            </x-slot>
        </x-table.table>

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


</div>

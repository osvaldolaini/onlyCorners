@php
    setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil');
    $d = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
    $today = strftime('%d de %B de %Y', $d->getTimestamp());

@endphp
<style>
    tr {
        text-align: left;
    }

    tr td {
        text-align: left;
    }
</style>
<table>
    <thead class="bg-gray-50 dark:bg-gray-800">
        <tr scope="col" class="text-gray-500 dark:text-gray-400">
            <th scope="col" class="px-4 py-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                Data
            </th>
            <th scope="col" class="px-4 py-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                Minuto
            </th>
            <th scope="col" class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                Favorecido
            </th>
            <th scope="col" class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                Campeonato
            </th>
            <th scope="col" class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                Jogo
            </th>
            <th scope="col" class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                Tempo
            </th>
        </tr>
    </thead>
    <tbody class="p-0 m-0 bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
        @foreach ($data as $item)
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
                        {{ $item->favored->nick }}
                    @else
                        Não informado
                    @endif

                </td>
                <td
                    class=" items-center mx-auto px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                    <div class="flex justify-center w-full mx-auto items-center ">
                        <div class="flex ">
                            @if ($item->championship_id)
                                {{ $item->championship->nick }}
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
                                {{ $item->team->nick }}
                            @else
                                Não informado
                            @endif
                        </div>

                        <span class="badge badge-error mx-auto">&nbsp; VS &nbsp;</span>

                        <div>
                            @if ($item->opponent_id)
                                {{ $item->opponent->nick }}
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
</table>

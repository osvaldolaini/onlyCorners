<div>
    <x-layouts.admin.breadcrumb>
        <div class="grid grid-cols-8 gap-4 text-gray-600 ">
            <div class="col-span-6 justify-items-start">
                <h3 class="text-2xl font-bold tracki dark:text-gray-50">
                    USUÁRIOS
                </h3>
            </div>
        </div>
    </x-layouts.admin.breadcrumb>
    <div class="flex flex-col items-center justify-between px-4 mt-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
        <div
            class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
            <div class="flex group ">
                <button wire:click="showModal"
                    class="flex items-center justify-center w-1/2 px-5 py-3 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    <span>Novo </span>
                </button>
            </div>
        </div>
    </div>
    <div class="my-6 bg-white dark:bg-gray-800 sm:rounded-lg">
        <div class="-mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden border border-gray-200 dark:border-gray-700 sm:rounded-lg">
                    <table style="width:100%" class='min-w-full divide-y divide-gray-200 dark:divide-gray-700'>
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr scope="col"
                                class="py-3.5 px-4 text-sm font-normal text-left text-gray-500
                                dark:text-gray-400">
                                <th scope="col"
                                    class="py-3.5 px-4 text-sm font-normal
                                            text-left
                                                    text-gray-500 dark:text-gray-400">
                                    Nome
                                </th>
                                <th scope="col"
                                    class="py-3.5 px-4 text-sm font-normal
                                            text-center
                                                    text-gray-500 dark:text-gray-400">
                                    Níveis de acesso
                                </th>
                                <th scope="col"
                                    class="py-3.5 px-4 text-sm font-normal
                                            text-center
                                            text-gray-500 dark:text-gray-400">
                                    Opções
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                            @foreach ($users as $user)
                                <tr>
                                    <td
                                        class="py-1.5 px-4 text-sm font-normal  text-left text-gray-500 dark:text-gray-400">
                                        {{ $user->name }}
                                    </td>
                                    <td
                                        class="py-1.5 px-4 text-sm font-normal  text-center text-gray-500
                                    dark:text-gray-400">
                                        {{-- @livewire('admin.users.user-groups', ['user' => $user], key($user->id)) --}}
                                    </td>
                                    <td
                                        class="w-1/6 py-1.5 px-4 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                                        <div class="w-full">
                                            <div class="flex justify-between font-medium duration-200 ">
                                                <div class="p-0 tooltip tooltip-top" data-tip="Editar">
                                                    <button wire:click="showModal({{ $user->id }})"
                                                        class="px-3 py-2 transition-colors duration-200 hover:text-white dark:hover:bg-blue-500 hover:hover:bg-blue-500 whitespace-nowrap">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 "
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="p-0 tooltip tooltip-top" data-tip="Apagar">
                                                    <button wire:click="showModalDelete({{ $user->id }})"
                                                        class="px-3 py-2 -ml-1 transition-colors duration-200 dark:hover:bg-red-500 hover:hover:bg-red-500 hover:text-white">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- <div class="items-center justify-between py-4">
            {{ $users->links() }}
        </div> --}}
    </div>
    {{-- MODAL DELETE --}}
    <x-layouts.admin.confirmation-modal wire:model="showJetModal">
        <x-slot name="title">
            Excluir registro
        </x-slot>

        <x-slot name="content">
            <h2 class="h2">Deseja realmente excluir o registro?</h2>
            <p>Não será possível reverter esta ação!</p>
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-secondary" wire:click="$toggle('showJetModal')" wire:loading.attr="disabled">
                Cancelar
            </button >

            <button class="ml-2 btn btn-error" wire:click="delete({{ $registerId }})" wire:loading.attr="disabled">
                Apagar registro
            </button>
        </x-slot>
    </x-layouts.admin.confirmation-modal>

    {{-- MODAL READ --}}
    <x-layouts.admin.dialog-modal wire:model="showModalView">
        <x-slot name="title">Detalhes</x-slot>
        <x-slot name="content">
            <dl class="text-gray-900 divide-y divide-gray-200 max-w dark:text-white dark:divide-gray-700">
                @if ($detail)
                    @foreach ($detail as $item => $value)
                        @if ($value)
                            @if ($item == 'Foto')
                                <figure class="w-48">
                                    <img class="photo" src="{{ $value }}" alt="Movie" />
                                </figure>
                            @else
                                <div class="flex flex-col pb-1">
                                    <dt class="text-gray-500 md:text-lg dark:text-gray-400">{{ $item }}:</dt>
                                    <dd class="text-lg font-semibold">
                                        {{ $value }}
                                    </dd>
                                </div>
                            @endif
                        @endif
                    @endforeach
                @endif
            </dl>
        </x-slot>
        <x-slot name="footer">
            <button class="btn btn-secondary" wire:click="$toggle('showModalView')" class="mx-2">
                Fechar
            </button>
        </x-slot>
    </x-layouts.admin.dialog-modal>


</div>

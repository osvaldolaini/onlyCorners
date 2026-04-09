<div class="flex flex-row w-full items-center justify-between mt-2">
    <div class="flex w-full">
        <div
            class="bg-gray-50 text-gray-900 text-sm
            focus:ring-blue-500 block w-full
            dark:bg-gray-700 dark:placeholder-gray-400
            dark:text-white dark:focus:ring-blue-500 ">
            <label for="simple-search" class="sr-only">
                Pesquisar
            </label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 right-0 flex items-center p-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-blue-500 dark:text-gray-400" fill="currentColor"
                        viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" placeholder="Pesquisar" wire:model.live="search"
                    class="w-full border-blue-500 py-3 pl-10 text-sm text-gray-900
                    rounded-2xl bg-gray-50 focus:ring-primary-500 dark:bg-gray-700
                    dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500" />
            </div>
        </div>
    </div>
    <div
        class="flex w-full justify-end">
        <button wire:click="modalCreate()"
                class="flex items-center justify-center w-1/2 px-5
                py-3 text-sm tracking-wide text-white transition-colors
                duration-200 bg-blue-500 rounded-lg sm:w-auto gap-x-2
                hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                <svg class="h-4 w-4 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                </svg>
                <span>Novo </span>
            </button>
    </div>
</div>

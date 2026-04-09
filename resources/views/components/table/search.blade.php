<div class="flex flex-row items-center justify-between w-full px-1 mt-2 lg:px-0">
    <div class="flex w-full mr-0 lg:mr-1">
        <div
            class="flex w-full text-sm text-gray-900 bg-gray-50 focus:ring-blue-500 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 ">

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
                    class="w-full p-3 text-sm text-gray-900 border-blue-500 rounded-2xl bg-gray-50 focus:ring-primary-500 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500" />
            </div>
        </div>
    </div>
    <div class="flex ">
        {{ $button ?? '' }}
    </div>
</div>

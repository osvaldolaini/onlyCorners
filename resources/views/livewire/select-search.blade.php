<div>
    @if ($label)
        <label class="block text-sm font-medium text-gray-900 dark:text-white">
            {{ $label }}
        </label>
    @endif

    <input type="hidden" name="{{ $nick }}" value="{{ $selected }}"
        @if ($required) required @endif>

    <div class="relative">

        @if (empty($selected))
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="{{ $placeholder }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                autocomplete="off">
        @endif

        @if (!empty($options) && empty($selected))
            <div
                class="absolute z-50 w-full mt-1 bg-gray-500 border border-gray-300 rounded-lg shadow-lg max-h-72 overflow-auto">
                @foreach ($options as $option)
                    <div wire:click="selectOption({{ $option['value'] }})"
                        class="px-4 py-3 hover:bg-blue-50 cursor-pointer dark:hover:bg-gray-600">
                        {{ $option['text'] }}
                    </div>
                @endforeach
            </div>
        @endif

        @if ($selected)
            @php
                $selectedText =
                    collect($options)->firstWhere('value', $selected)['text'] ??
                    ($this->model::find($selected)?->nick ?? 'Item selecionado');
            @endphp

            <div
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <div class="flex justify-between items-center">
                    <span class="font-medium">{{ $selectedText }}</span>
                    <button type="button" wire:click="clear"
                        class="text-red-600 hover:text-red-700 font-medium px-3  rounded hover:bg-red-100 dark:hover:bg-red-900">
                        ✕ Remover
                    </button>
                </div>
            </div>
        @endif

    </div>

    @error($nick)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

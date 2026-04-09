@props(['page', 'title', 'dashboard'])
<div>
    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r
    dark:border-gray-600  ">
        <div class="flex justify-around items-center px-3">
            <label
                class="w-full flex py-3 mx-2 text-sm font-medium
                    text-gray-900 dark:text-gray-300 items-center">
                {{ $slot }}
                <span class="ml-2">{{ $title }}</span>
            </label>
            <input id="vue-checkbox-list" name="dashboard" type="radio" wire:click='changeDashboard({{ $page }})'
                class="w-4 h-4 text-blue-500 bg-gray-100 border-gray-300 rounded
             focus:ring-blue-400 dark:focus:ring-blue-400 dark:ring-offset-gray-700
              dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600
              dark:border-gray-500 cursor-pointer"
                @if ($page == $dashboard) checked="checked" @endif>
        </div>
    </li>

</div>

@props(['page', 'title', 'access'])
<div>
    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600 ">
        <div class="flex items-center justify-between px-3">
            <label class="flex items-center w-full py-3 mx-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                {{ $slot }}
                <span class="ml-2">{{ $title }}</span>
            </label>
            <div class="flex text-right cursor-pointer custom-checkbox " wire:click="changeAccess('{{ $page }}')"
                data-value="{{ $page }}">
                @if (in_array($page, $access) || in_array('all', $access))
                    <svg class="block w-6 h-6 transition duration-100 rounded-md checked bg-cyan-500 " viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="Interface / Check">
                            <path id="Vector" d="M6 12L10.2426 16.2426L18.727 7.75732" stroke="#000000"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                    </svg>
                @else
                    <svg class="block w-6 h-6 transition duration-100 rounded-md border-cyan-500 checked "
                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="24" height="24" fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M7.25007 2.38782C8.54878 2.0992 10.1243 2 12 2C13.8757 2 15.4512 2.0992 16.7499 2.38782C18.06 2.67897 19.1488 3.176 19.9864 4.01358C20.824 4.85116 21.321 5.94002 21.6122 7.25007C21.9008 8.54878 22 10.1243 22 12C22 13.8757 21.9008 15.4512 21.6122 16.7499C21.321 18.06 20.824 19.1488 19.9864 19.9864C19.1488 20.824 18.06 21.321 16.7499 21.6122C15.4512 21.9008 13.8757 22 12 22C10.1243 22 8.54878 21.9008 7.25007 21.6122C5.94002 21.321 4.85116 20.824 4.01358 19.9864C3.176 19.1488 2.67897 18.06 2.38782 16.7499C2.0992 15.4512 2 13.8757 2 12C2 10.1243 2.0992 8.54878 2.38782 7.25007C2.67897 5.94002 3.176 4.85116 4.01358 4.01358C4.85116 3.176 5.94002 2.67897 7.25007 2.38782Z"
                            fill="currenteColor" />
                    </svg>
                @endif
            </div>
        </div>
    </li>
</div>

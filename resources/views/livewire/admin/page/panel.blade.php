<div class="pt-3 w-100 sm:rounded-lg">
    <div class="grid w-full grid-cols-6 gap-2">
        <span class="col-span-full sm:col-span-2">
            <div class="relative h-32 overflow-hidden bg-blue-500 rounded-lg shadow-md">
                @if ($config->id)
                    <picture class="absolute w-24 h-24 text-red-800 rounded-md opacity-50 top-2 -right-4 md:-right-4">
                        <source srcset="{{ url('storage/logos-school/logo.png') }}" />
                        <source srcset="{{ url('storage/logos-school/logo.webp') }}" />
                        <img class="absolute w-24 h-24 text-red-800 rounded-md opacity-50 top-2 -right-4 md:-right-4"
                            src="{{ url('storage/logos-school/logo.png') }}" alt="api-gerencia">
                    </picture>
                @else
                    <svg class="absolute w-24 h-24 text-red-800 rounded-md opacity-50 top-2 -right-4 md:-right-4"
                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13 20V18C13 15.2386 10.7614 13 8 13C5.23858 13 3 15.2386 3 18V20H13ZM13 20H21V19C21 16.0545 18.7614 14 16 14C14.5867 14 13.3103 14.6255 12.4009 15.6311M11 7C11 8.65685 9.65685 10 8 10C6.34315 10 5 8.65685 5 7C5 5.34315 6.34315 4 8 4C9.65685 4 11 5.34315 11 7ZM18 9C18 10.1046 17.1046 11 16 11C14.8954 11 14 10.1046 14 9C14 7.89543 14.8954 7 16 7C17.1046 7 18 7.89543 18 9Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                @endif
                <div class="p-4 ">
                    <dl>
                        <dt class="text-sm font-medium leading-5 text-white truncate">
                            Alunos do {{ $config->nick }}
                        </dt>
                        <dd class="mt-1 text-5xl font-bold leading-9 text-white">
                            {{ $teams }}
                        </dd>
                    </dl>
                </div>
            </div>
        </span>


    </div>
</div>

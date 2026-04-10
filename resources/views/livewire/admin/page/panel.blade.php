<div class="pt-3 w-100 sm:rounded-lg">
    <div class="grid w-full grid-cols-6 gap-2">
        <a href="{{ route('teams-list') }}" class="col-span-full sm:col-span-3">
            <div class="relative h-32 overflow-hidden bg-blue-500 rounded-lg shadow-md">
                <x-layout.svg.shield
                    class="absolute w-24 h-24 text-blue-800 rounded-md opacity-50 -top-3 -right-6 md:-right-6">
                </x-layout.svg.shield>
                <div class="p-4 ">
                    <dl>
                        <dt class="text-sm font-medium leading-5 text-white truncate">
                            Clubes
                        </dt>
                        <dd class="mt-1 text-5xl font-bold leading-9 text-white">
                            {{ $teams }}
                        </dd>
                    </dl>
                </div>
            </div>
        </a>
        <a href="{{ route('championships-list') }}" class="col-span-full sm:col-span-3">
            <div class="relative h-32 overflow-hidden bg-blue-500 rounded-lg shadow-md">
                <x-layout.svg.trophy
                    class="absolute w-24 h-24 text-blue-800 rounded-md opacity-50 -top-3 -right-6 md:-right-6">
                </x-layout.svg.trophy>
                <div class="p-4 ">
                    <dl>
                        <dt class="text-sm font-medium leading-5 text-white truncate">
                            Campeonatos
                        </dt>
                        <dd class="mt-1 text-5xl font-bold leading-9 text-white">
                            {{ $championships }}
                        </dd>
                    </dl>
                </div>
            </div>
        </a>
    </div>
</div>

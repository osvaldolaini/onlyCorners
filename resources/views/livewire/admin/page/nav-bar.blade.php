<nav x-data="{ open: false }"
    class="text-white bg-gray-900 border-b border-gray-900 dark:bg-gray-800 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}" aria-label="Ir para homepage">
                        <div class="">
                            {{-- @livewire('admin.logos') --}}
                            <x-layouts.admin.application-logo width="h-12"></x-layouts.admin.application-logo>
                        </div>
                    </a>
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Settings Dropdown -->
                <div class="relative ml-3">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">

                                <button
                                    class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                    <img class="object-cover w-8 h-8 rounded-full"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>

                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            {{-- <x-layouts.admin.dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-layouts.admin.dropdown-link> --}}

                            <div class="border-t border-gray-200 dark:border-gray-600"></div>
                            <div class="flex items-center w-full mx-auto ">
                                <div class="flex w-1/2 p-0 tooltip tooltip-top"
                                    data-tip="{{ auth()->user()->dark ? 'Dark' : 'Light' }}">
                                    <div
                                        class="flex w-full px-4 py-2 mx-auto text-sm leading-5 text-center text-gray-700 transition duration-150 ease-in-out border-r border-gray-200 dark:border-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800">
                                        @livewire('admin.users.dark')
                                    </div>
                                </div>
                                <div class="flex w-1/2 p-0 tooltip tooltip-top"
                                    data-tip="{{ auth()->user()->panel == 'admin' ? 'Administração' : 'Usuário' }}">
                                    <div
                                        class="flex w-full px-4 py-2 mx-auto text-sm leading-5 text-center text-gray-700 transition duration-150 ease-in-out border-gray-200 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800">
                                        @livewire('admin.users.panel')
                                    </div>
                                </div>
                            </div>


                            <div class="border-t border-gray-200 dark:border-gray-600"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-layouts.admin.dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-layouts.admin.dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
            {{-- User --}}
            @if (Auth::user()->panel == 'user')
                <div class="flex items-center ml-6">
                    <!-- Settings Dropdown -->
                    <div class="relative ml-3">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                  <button
                                        class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                        <img class="object-cover w-8 h-8 rounded-full"
                                            src="{{ Auth::user()->profile_photo_url }}"
                                            alt="{{ Auth::user()->name }}" />
                                    </button>

                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>

                                {{-- <x-layouts.admin.dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-layouts.admin.dropdown-link> --}}

                                <div class="border-t border-gray-200 dark:border-gray-600"></div>
                                <div class="flex items-center w-full mx-auto ">
                                    <div class="flex w-1/2 p-0 tooltip tooltip-top"
                                        data-tip="{{ auth()->user()->dark ? 'Dark' : 'Light' }}">
                                        <div
                                            class="flex w-full px-4 py-2 mx-auto text-sm leading-5 text-center text-gray-700 transition duration-150 ease-in-out border-r border-gray-200 dark:border-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800">
                                            @livewire('admin.users.dark')
                                        </div>
                                    </div>
                                    <div class="flex w-1/2 p-0 tooltip tooltip-top"
                                        data-tip="{{ auth()->user()->panel == 'admin' ? 'Administração' : 'Usuário' }}">
                                        <div
                                            class="flex w-full px-4 py-2 mx-auto text-sm leading-5 text-center text-gray-700 transition duration-150 ease-in-out border-gray-200 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800">
                                            @livewire('admin.users.panel')
                                        </div>
                                    </div>
                                </div>


                                <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-layouts.admin.dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-layouts.admin.dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            @endif

            {{-- end user --}}
            @if (Auth::user()->panel == 'admin')
                <div class="flex items-center -mr-2 sm:hidden">
                    <label for="my-drawer-3"
                        class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="inline-block w-6 h-6 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </label>
                </div>
            @endif
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    @if (Auth::user()->panel == 'admin')
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-layouts.admin.responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-layouts.admin.responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="flex items-center px-4">
                       <div class="mr-3 shrink-0">
                            <img class="object-cover w-10 h-10 rounded-full"
                                src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </div>


                    <div>
                        <div class="text-base font-medium text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}
                        </div>
                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    {{-- <!-- Account Management -->
                    <x-layouts.admin.responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                        {{ __('Profile') }}
                    </x-layouts.admin.responsive-nav-link> --}}

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf

                        <x-layouts.admin.responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </x-layouts.admin.responsive-nav-link>
                    </form>


                </div>
            </div>
        </div>
    @endif


</nav>

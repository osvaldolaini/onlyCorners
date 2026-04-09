@props(['url', 'active', 'page' => null])
<div>
    @if (in_array($page, auth()->user()->jsonAccesses) || in_array('all', auth()->user()->jsonAccesses))
        <a href="{{ route($url) }}"
            class="flex items-center justify-start w-full px-4 py-0.5 my-0
                    font-thin uppercase transition-colors duration-200
                    {{ Request::is($active)
                        ? ' bg-gradient-to-r from-white to-blue-100 dark:from-gray-700 dark:to-gray-900                                                                                                                                                                                                                                  dark:from-gray-700 dark:to-gray-200 text-blue-500 border-r-4 border-blue-500'
                        : 'dark:text-gray-200 hover:text-blue-500 text-gray-900' }}">
            {{ $slot }}
        </a>
    @endif
</div>

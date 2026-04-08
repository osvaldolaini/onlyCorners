@props(['url', 'active', 'access_page' => null])
<div>
    @if (in_array($access_page, auth()->user()->jsonAccesses) || in_array('all', auth()->user()->jsonAccesses))
        <a href="{{ route($url) }}"
            class="flex items-center justify-start px-2 py-1 my-0  transition-colors duration-200
            {{ Request::is($active)
                ? 'hover:text-blue-900 dark:hover:text-blue-500 text-blue-500 dark:text-blue-300 bg-gray-100 border-r-8 border-blue-400 dark:border-blue-500 dark:bg-gray-600'
                : 'text-gray-800 hover:text-gray-800 hover:bg-gray-100 dark:hover:text-white dark:hover:bg-gray-600 dark:text-gray-100' }}">
            {{ $svg }}
            <span class="ml-2 mr-4 font-normal ">
                {{ $title }}
            </span>
        </a>
    @endif
</div>

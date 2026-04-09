@props(['url', 'active'])
<div>
    <li
        class="font-thin uppercase transition-colors duration-200
    {{ Request::is($active)
        ? ' bg-gradient-to-r from-white to-blue-100                                                                                         dark:from-gray-700 dark:to-gray-200 text-blue-500 border-r-4 border-blue-500'
        : 'dark:text-gray-200 hover:text-blue-500 text-gray-500' }}">
        <a href="{{ route($url) }}"
            class="flex sm:text-xs items-center px-4 py-1 my-0 hover:bg-gray-100 dark:hover:bg-gray-600
        dark:hover:text-white">
            {{ $slot }}
        </a>
    </li>
</div>

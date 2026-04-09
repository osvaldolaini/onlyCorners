<div>
    @props(['tab'])
    <a href="#{{ $tab }}"
        :class="activeTab === '#{{ $tab }}' ?
            'bg-gray-500 text-white active dark:text-gray-900 rounded-md' :
            'border-transparent text-gray-500 hover:text-gray-600 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-300'"
        role="tab" id="{{ $tab }}-tab" @click="activeTab = '#{{ $tab }}'"
        class="flex items-center px-3 py-2 text-sm font-medium transition duration-75">
        {{ $svg }}
        <span class="px-1 transition duration-75 text-primary-600 dark:text-primary-400">
            {{ $title }}
        </span>
    </a>
</div>

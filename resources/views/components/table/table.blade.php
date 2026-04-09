<div class="py-3">
    <div class="overflow-x-auto bg-white dark:bg-gray-800 sm:rounded-lg">
        <table class='w-full p-0 m-0 uppercase divide-y divide-gray-200 dark:divide-gray-700'>
            {{ $head ?? '' }}
            {{ $body ?? '' }}
        </table>
    </div>

    <div class="items-center justify-between py-4">
        {{ $link ?? '' }}
    </div>
</div>

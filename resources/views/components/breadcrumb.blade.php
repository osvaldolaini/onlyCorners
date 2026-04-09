<div class="py-4 rounded-2xl dark:bg-gray-700 ">
    @props(['excluded' => true])
    <div class="flex justify-between mx-2 space-x-2 text-gray-600 lg:mx-1">
        {{ $left ?? '' }}
        {{ $center ?? '' }}
        {{ $right ?? '' }}
        @if ($excluded)
            @livewire('admin.users.see-excluded')
        @endif
    </div>
</div>

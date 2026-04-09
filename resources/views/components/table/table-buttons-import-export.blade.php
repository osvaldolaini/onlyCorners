@props(['import', 'export'])
<div>
    <div class="flex px-4 pt-4 space-x-2 ">
        @if (isset($export))
            <div>
                @livewire('students.sheets-export')
            </div>
        @endif
        @if (isset($import))
            <div>
                @livewire('students.sheets-import')
            </div>
        @endif

    </div>
</div>

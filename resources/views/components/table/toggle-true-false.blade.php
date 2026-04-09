@props(['id', 'active'])

<label for="{{ $id }}" class="inline-flex items-center p-1 text-gray-100 cursor-pointer dark:bg-gray-700">
    <input id="{{ $id }}" wire:model.live='{{ $id }}' {{ $active ? 'checked' : '' }} type="checkbox"
        class="hidden peer">
    <span class="px-4 py-2 bg-red-500 peer-checked:bg-gray-700 peer-checked:text-gray-900">NÃO</span>
    <span class="px-4 py-2 bg-gray-700 peer-checked:bg-blue-600">SIM</span>
</label>

<div>
    <div class="badge">default</div>
    <div class="badge badge-neutral">neutral</div>
    <div class="badge badge-primary">primary</div>
    <div class="badge badge-secondary">secondary</div>
    <div class="badge badge-accent">accent</div>
    <div class="badge badge-ghost">ghost</div>
    <div class="badge badge-info">info</div>
    <div class="badge badge-success">success</div>
    <div class="badge badge-warning">warning</div>
    <div class="badge badge-error">error</div>
</div>
<label for="{{ $id }}"
    class="inline-flex items-center p-1 cursor-pointer dark:bg-gray-700 dark:text-gray-100">
    <input id="{{ $id }}" wire:model.live='{{ $id }}' type="checkbox" class="hidden peer">
    <span class="px-4 py-2 bg-red-500 peer-checked:bg-gray-700 peer-checked:ttext-gray-900">NÃO</span>
    <span class="px-4 py-2 bg-gray-400 peer-checked:bg-gray-700 peer-checked:text-gray-900">NÃO</span>
    <span class="px-4 py-2 bg-gray-700 peer-checked:bg-blue-600">SIM</span>
    <span class="bg-blue-600"></span>
    <span class="bg-blue-400"></span>
    <span class="bg-blue-700"></span>
    <span class="bg-red-200"></span>bg-red-200
</label>

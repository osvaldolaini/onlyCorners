@props(['title' => 'Acessos', 'description' => 'Descrição do acesso'])
<div class="mx-3 mb-5 bg-gray-200 sm:mx-4 sm:p-5 rounded-2xl dark:bg-gray-700">
    <div class="flex justify-between md:col-span-1">
        <div class="w-1/3 px-4 sm:px-0">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $title }}</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ $description }}
            </p>
        </div>
        <div class="w-2/3 ">
            {{ $slot }}
        </div>
    </div>
</div>

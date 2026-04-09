<style>
    [x-cloak] {
        display: none !important;
    }
</style>
<div x-cloak x-data="{ activeTab: window.location.hash ? window.location.hash : '#tab1' }" class="mx-3 sm:mx-4">
    <!-- Tabs Navigation -->
    <div class="flex max-w-full p-2 overflow-x-auto border-gray-200 gap-x-1 dark:border-white/10">
        {{ $nav }}
    </div>

    <!-- Tabs Content -->
    <div class="mb-5">
        {{ $content }}
    </div>
</div>

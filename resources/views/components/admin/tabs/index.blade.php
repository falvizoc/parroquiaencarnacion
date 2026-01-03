{{--
    Componente de navegación por tabs para el panel admin.

    Uso:
    <x-admin.tabs>
        <x-admin.tabs.item :active="$activeTab === 'tab1'" wire:click="setActiveTab('tab1')">
            <x-slot:icon>
                <svg>...</svg>
            </x-slot:icon>
            Nombre del Tab
        </x-admin.tabs.item>
    </x-admin.tabs>
--}}

@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'mb-6 ' . $class]) }}>
    <nav class="flex space-x-1 rounded-xl bg-gray-100 dark:bg-gray-800 p-1" aria-label="Tabs">
        {{ $slot }}
    </nav>
</div>

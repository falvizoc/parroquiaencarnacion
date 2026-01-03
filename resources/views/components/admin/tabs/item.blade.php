{{--
    Componente de item/pestaña individual para navegación por tabs.

    Props:
    - active: boolean - Si el tab está activo
    - icon: slot - Ícono SVG del tab (opcional, preferiblemente ícono de marca oficial)

    Uso:
    <x-admin.tabs.item :active="$activeTab === 'openai'" wire:click="setActiveTab('openai')">
        <x-slot:icon>
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">...</svg>
        </x-slot:icon>
        OpenAI
    </x-admin.tabs.item>
--}}

@props(['active' => false])

<button
    type="button"
    {{ $attributes->merge([
        'class' => 'flex items-center gap-2 rounded-lg px-4 py-2.5 text-sm font-medium transition-all duration-200 cursor-pointer ' .
            ($active
                ? 'bg-white dark:bg-gray-900 text-primary-600 dark:text-primary-400 shadow-sm'
                : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 hover:bg-white/50 dark:hover:bg-gray-700/50')
    ]) }}
>
    @isset($icon)
        <span class="flex-shrink-0 [&>svg]:h-5 [&>svg]:w-5">
            {{ $icon }}
        </span>
    @endisset
    <span>{{ $slot }}</span>
</button>

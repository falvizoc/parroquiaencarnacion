@props(['active' => false])

<a {{ $attributes->merge([
    'class' => 'px-4 py-2 rounded-lg text-sm font-medium transition-colors ' .
        ($active
            ? 'bg-primary-50 text-primary-700'
            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900')
]) }}>
    {{ $slot }}
</a>

@props(['active' => false])

<a {{ $attributes->merge([
    'class' => 'block px-4 py-3 rounded-lg text-base font-medium transition-colors ' .
        ($active
            ? 'bg-primary-50 text-primary-700'
            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900')
]) }}>
    {{ $slot }}
</a>

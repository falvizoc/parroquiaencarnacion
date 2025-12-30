@props([
    'src' => '',
    'alt' => '',
    'class' => '',
    'width' => null,
    'height' => null,
    'eager' => false,
    'placeholder' => true
])

@php
    $loadingAttr = $eager ? 'eager' : 'lazy';
    $decodingAttr = $eager ? 'sync' : 'async';
    $fetchPriority = $eager ? 'high' : 'auto';

    // Generar URL de storage si no es URL completa
    $imageSrc = str_starts_with($src, 'http') ? $src : asset('storage/' . $src);

    // Placeholder blur (color sólido o imagen tiny)
    $placeholderBg = 'bg-gray-200';
@endphp

<div class="relative overflow-hidden {{ $placeholderBg }} {{ $class }}"
     @if($width && $height) style="aspect-ratio: {{ $width }}/{{ $height }}" @endif>
    <img
        src="{{ $imageSrc }}"
        alt="{{ $alt }}"
        loading="{{ $loadingAttr }}"
        decoding="{{ $decodingAttr }}"
        fetchpriority="{{ $fetchPriority }}"
        @if($width) width="{{ $width }}" @endif
        @if($height) height="{{ $height }}" @endif
        class="w-full h-full object-cover transition-opacity duration-300"
        onload="this.parentElement.classList.remove('{{ $placeholderBg }}')"
        onerror="this.style.display='none'"
    >
</div>

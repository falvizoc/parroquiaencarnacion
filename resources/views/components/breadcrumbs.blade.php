@props(['items' => []])

@if(count($items) > 0)
<nav aria-label="Breadcrumb" class="bg-gray-100 py-3">
    <div class="container mx-auto px-4">
        <ol class="flex flex-wrap items-center gap-2 text-sm" itemscope itemtype="https://schema.org/BreadcrumbList">
            {{-- Home siempre primero --}}
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="{{ route('inicio', ['locale' => app()->getLocale()]) }}"
                   itemprop="item"
                   class="text-gray-600 hover:text-primary-600 transition-colors">
                    <span itemprop="name">{{ __('general.nav.home') }}</span>
                </a>
                <meta itemprop="position" content="1">
            </li>

            @foreach($items as $index => $item)
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        @if($loop->last)
                            <span itemprop="name" class="text-gray-900 font-medium">{{ $item['nombre'] }}</span>
                        @else
                            <a href="{{ $item['url'] }}"
                               itemprop="item"
                               class="text-gray-600 hover:text-primary-600 transition-colors">
                                <span itemprop="name">{{ $item['nombre'] }}</span>
                            </a>
                        @endif
                        <meta itemprop="position" content="{{ $index + 2 }}">
                    </span>
                </li>
            @endforeach
        </ol>
    </div>
</nav>
@endif

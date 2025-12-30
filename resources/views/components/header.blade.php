<header class="sticky top-0 z-40 w-full bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80 border-b border-gray-100">
    {{-- Top Bar --}}
    <div class="bg-primary-900 text-white text-sm">
        <div class="container-main py-2 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <span class="hidden sm:inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ __('general.site.location') }}
                </span>
            </div>
            <div class="flex items-center gap-4">
                {{-- Selector de idioma --}}
                <div class="flex items-center gap-2">
                    <a href="{{ route('cambiar.idioma', 'es') }}"
                       class="{{ app()->getLocale() == 'es' ? 'font-bold underline' : 'hover:underline' }}">
                        ES
                    </a>
                    <span class="text-white/50">|</span>
                    <a href="{{ route('cambiar.idioma', 'en') }}"
                       class="{{ app()->getLocale() == 'en' ? 'font-bold underline' : 'hover:underline' }}">
                        EN
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Navigation --}}
    <nav class="container-main" x-data="{ mobileMenuOpen: false }">
        <div class="flex items-center justify-between h-16 lg:h-20">
            {{-- Logo --}}
            <a href="{{ route('inicio', ['locale' => app()->getLocale()]) }}" class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-primary-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 lg:w-8 lg:h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <div class="hidden sm:block">
                    <div class="font-serif font-bold text-lg text-primary-900 leading-tight">
                        {{ __('general.site.short_name') }}
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ __('general.site.location') }}
                    </div>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden lg:flex items-center gap-1">
                <x-nav-link href="{{ route('inicio', ['locale' => app()->getLocale()]) }}" :active="request()->routeIs('inicio')">
                    {{ __('general.nav.home') }}
                </x-nav-link>
                <x-nav-link href="{{ route('horarios', ['locale' => app()->getLocale()]) }}" :active="request()->routeIs('horarios')">
                    {{ __('general.nav.schedules') }}
                </x-nav-link>
                <x-nav-link href="{{ route('noticias.index', ['locale' => app()->getLocale()]) }}" :active="request()->routeIs('noticias.*')">
                    {{ __('general.nav.news') }}
                </x-nav-link>
                <x-nav-link href="{{ route('eventos.index', ['locale' => app()->getLocale()]) }}" :active="request()->routeIs('eventos.*')">
                    {{ __('general.nav.events') }}
                </x-nav-link>
                <x-nav-link href="{{ route('grupos.index', ['locale' => app()->getLocale()]) }}" :active="request()->routeIs('grupos.*')">
                    {{ __('general.nav.groups') }}
                </x-nav-link>
                <x-nav-link href="{{ route('capillas.index', ['locale' => app()->getLocale()]) }}" :active="request()->routeIs('capillas.*')">
                    {{ __('general.nav.chapels') }}
                </x-nav-link>
                <x-nav-link href="{{ route('sacerdotes', ['locale' => app()->getLocale()]) }}" :active="request()->routeIs('sacerdotes')">
                    {{ __('general.nav.priests') }}
                </x-nav-link>
                <x-nav-link href="{{ route('adoracion', ['locale' => app()->getLocale()]) }}" :active="request()->routeIs('adoracion')">
                    {{ __('general.nav.adoration') }}
                </x-nav-link>
                <x-nav-link href="{{ route('contacto', ['locale' => app()->getLocale()]) }}" :active="request()->routeIs('contacto')">
                    {{ __('general.nav.contact') }}
                </x-nav-link>
            </div>

            {{-- CTA Button (Desktop) --}}
            <div class="hidden lg:block">
                <a href="{{ route('registro', ['locale' => app()->getLocale()]) }}" class="btn-primary">
                    {{ __('general.nav.register') }}
                </a>
            </div>

            {{-- Mobile Menu Button --}}
            <button
                @click="mobileMenuOpen = !mobileMenuOpen"
                class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100"
                :aria-expanded="mobileMenuOpen"
                aria-label="Menú de navegación"
            >
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div
            x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="lg:hidden border-t border-gray-100 py-4"
            x-cloak
        >
            <div class="flex flex-col gap-1">
                <x-nav-link-mobile href="{{ route('inicio', ['locale' => app()->getLocale()]) }}" :active="request()->routeIs('inicio')">
                    {{ __('general.nav.home') }}
                </x-nav-link-mobile>
                <x-nav-link-mobile href="{{ route('horarios', ['locale' => app()->getLocale()]) }}" :active="request()->routeIs('horarios')">
                    {{ __('general.nav.schedules') }}
                </x-nav-link-mobile>
                <x-nav-link-mobile href="{{ route('noticias.index', ['locale' => app()->getLocale()]) }}" :active="request()->routeIs('noticias.*')">
                    {{ __('general.nav.news') }}
                </x-nav-link-mobile>
                <x-nav-link-mobile href="{{ route('eventos.index', ['locale' => app()->getLocale()]) }}" :active="request()->routeIs('eventos.*')">
                    {{ __('general.nav.events') }}
                </x-nav-link-mobile>
                <x-nav-link-mobile href="{{ route('grupos.index', ['locale' => app()->getLocale()]) }}" :active="request()->routeIs('grupos.*')">
                    {{ __('general.nav.groups') }}
                </x-nav-link-mobile>
                <x-nav-link-mobile href="{{ route('capillas.index', ['locale' => app()->getLocale()]) }}" :active="request()->routeIs('capillas.*')">
                    {{ __('general.nav.chapels') }}
                </x-nav-link-mobile>
                <x-nav-link-mobile href="{{ route('sacerdotes', ['locale' => app()->getLocale()]) }}" :active="request()->routeIs('sacerdotes')">
                    {{ __('general.nav.priests') }}
                </x-nav-link-mobile>
                <x-nav-link-mobile href="{{ route('adoracion', ['locale' => app()->getLocale()]) }}" :active="request()->routeIs('adoracion')">
                    {{ __('general.nav.adoration') }}
                </x-nav-link-mobile>
                <x-nav-link-mobile href="{{ route('contacto', ['locale' => app()->getLocale()]) }}" :active="request()->routeIs('contacto')">
                    {{ __('general.nav.contact') }}
                </x-nav-link-mobile>
                <div class="pt-4 mt-2 border-t border-gray-100">
                    <a href="{{ route('registro', ['locale' => app()->getLocale()]) }}" class="btn-primary w-full text-center">
                        {{ __('general.nav.register') }}
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>

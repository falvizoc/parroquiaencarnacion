<footer class="bg-primary-950 text-white">
    {{-- Main Footer --}}
    <div class="container-main py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
            {{-- Columna 1: Información de la Parroquia --}}
            <div class="lg:col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-gold-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-serif font-bold text-lg leading-tight">
                            {{ __('general.site.short_name') }}
                        </div>
                    </div>
                </div>
                <p class="text-white/70 text-sm mb-4">
                    {{ __('general.site.tagline') }}
                </p>
                <div class="flex items-center gap-2 text-sm text-white/70">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ __('general.site.location') }}
                </div>
            </div>

            {{-- Columna 2: Enlaces Rápidos --}}
            <div>
                <h3 class="font-semibold text-lg mb-4">Navegación</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('horarios', ['locale' => app()->getLocale()]) }}" class="text-white/70 hover:text-white transition-colors">
                            {{ __('general.nav.schedules') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('eventos.index', ['locale' => app()->getLocale()]) }}" class="text-white/70 hover:text-white transition-colors">
                            {{ __('general.nav.events') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('grupos.index', ['locale' => app()->getLocale()]) }}" class="text-white/70 hover:text-white transition-colors">
                            {{ __('general.nav.groups') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('adoracion', ['locale' => app()->getLocale()]) }}" class="text-white/70 hover:text-white transition-colors">
                            {{ __('general.nav.adoration') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contacto', ['locale' => app()->getLocale()]) }}" class="text-white/70 hover:text-white transition-colors">
                            {{ __('general.nav.contact') }}
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Columna 3: Horarios --}}
            <div>
                <h3 class="font-semibold text-lg mb-4">Horarios de Misa</h3>
                <ul class="space-y-2 text-sm text-white/70">
                    <li class="flex justify-between">
                        <span>Domingo</span>
                        <span>8:00, 10:00, 12:00, 19:00</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Lunes a Viernes</span>
                        <span>7:00, 19:00</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Sábado</span>
                        <span>8:00, 19:00</span>
                    </li>
                </ul>
                <a href="{{ route('horarios', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center gap-1 text-gold-400 hover:text-gold-300 text-sm mt-4 transition-colors">
                    Ver todos los horarios
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            {{-- Columna 4: Contacto y Redes --}}
            <div>
                <h3 class="font-semibold text-lg mb-4">Contacto</h3>
                <ul class="space-y-3 text-sm text-white/70">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>(833) 123-4567</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>contacto@parroquiaencarnaciontampico.org</span>
                    </li>
                </ul>

                {{-- Redes Sociales --}}
                <div class="mt-6">
                    <h4 class="font-medium mb-3">{{ __('general.footer.follow_us') }}</h4>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition-colors" aria-label="Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition-colors" aria-label="YouTube">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-white/10">
        <div class="container-main py-6 flex flex-col sm:flex-row justify-between items-center gap-4 text-sm text-white/60">
            <p>
                &copy; {{ date('Y') }} {{ __('general.site.name') }}. {{ __('general.footer.rights') }}.
            </p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-white transition-colors">{{ __('general.footer.privacy') }}</a>
                <a href="#" class="hover:text-white transition-colors">{{ __('general.footer.terms') }}</a>
            </div>
        </div>
    </div>
</footer>

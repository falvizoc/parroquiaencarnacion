<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#7c3aed">
    <meta name="color-scheme" content="light">

    {{-- SEO Meta Tags --}}
    <title>@yield('title', $seo->getTitulo())</title>
    <meta name="description" content="@yield('description', $seo->getDescripcion())">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="{{ $seo->getTipo() }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', $seo->getTitulo())">
    <meta property="og:description" content="@yield('description', $seo->getDescripcion())">
    <meta property="og:image" content="@yield('og_image', $seo->getImagen())">
    <meta property="og:locale" content="{{ app()->getLocale() == 'es' ? 'es_MX' : 'en_US' }}">
    <meta property="og:site_name" content="{{ __('general.site.name') }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $seo->getTitulo())">
    <meta name="twitter:description" content="@yield('description', $seo->getDescripcion())">
    <meta name="twitter:image" content="@yield('og_image', $seo->getImagen())">

    {{-- Alternate Languages --}}
    <link rel="alternate" hreflang="es" href="{{ url('/es' . request()->getPathInfo()) }}">
    <link rel="alternate" hreflang="en" href="{{ url('/en' . request()->getPathInfo()) }}">
    <link rel="alternate" hreflang="x-default" href="{{ url('/es' . request()->getPathInfo()) }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    {{-- Performance: DNS Prefetch y Preconnect --}}
    <link rel="dns-prefetch" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>

    {{-- Fonts con display swap para evitar FOIT --}}
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|playfair-display:400,500,600,700&display=swap" rel="stylesheet">

    {{-- Styles con preload para CSS crítico --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Preload de recursos críticos --}}
    @stack('preload')

    {{-- Analytics --}}
    <x-analytics />

    {{-- Additional Head Content --}}
    @stack('head')
</head>
<body class="min-h-screen bg-gray-50 font-sans text-gray-900 antialiased">
    {{-- Skip Link para Accesibilidad --}}
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-primary-600 focus:text-white focus:px-4 focus:py-2 focus:rounded">
        Saltar al contenido principal
    </a>

    {{-- Header --}}
    <x-header />

    {{-- Breadcrumbs --}}
    @hasSection('breadcrumbs')
        @yield('breadcrumbs')
    @endif

    {{-- Main Content --}}
    <main id="main-content" class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    <x-footer />

    {{-- Scripts adicionales --}}
    @stack('scripts')

    {{-- Schema.org JSON-LD --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Church",
        "name": "{{ __('general.site.name') }}",
        "description": "{{ __('general.seo.default_description') }}",
        "url": "{{ config('app.url') }}",
        "address": {
            "@@type": "PostalAddress",
            "addressLocality": "Tampico",
            "addressRegion": "Tamaulipas",
            "addressCountry": "MX"
        },
        "geo": {
            "@@type": "GeoCoordinates",
            "latitude": "22.2475",
            "longitude": "-97.8508"
        }
    }
    </script>
    @stack('schema')
</body>
</html>

@php
    use App\Models\Setting;

    $analyticsActivo = Setting::obtener('analytics_activo', false);
    $ga4Id = Setting::obtener('ga4_measurement_id', '');
    $searchConsoleVerificacion = Setting::obtener('search_console_verificacion', '');
@endphp

{{-- Google Search Console Verification --}}
@if($searchConsoleVerificacion)
    <meta name="google-site-verification" content="{{ $searchConsoleVerificacion }}">
@endif

{{-- Google Analytics 4 --}}
@if($analyticsActivo && $ga4Id)
    {{-- gtag.js --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4Id }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $ga4Id }}', {
            'anonymize_ip': true,
            'cookie_flags': 'SameSite=None;Secure'
        });

        // Función helper para eventos personalizados
        window.trackEvent = function(eventName, parameters = {}) {
            if (typeof gtag === 'function') {
                gtag('event', eventName, parameters);
            }
        };

        // Eventos de conversión predefinidos
        window.trackConversion = {
            // Registro de fiel
            registro: function() {
                trackEvent('sign_up', {
                    'method': 'form'
                });
            },
            // Suscripción newsletter
            newsletter: function() {
                trackEvent('newsletter_signup', {
                    'event_category': 'engagement'
                });
            },
            // Envío de formulario de contacto
            contacto: function() {
                trackEvent('contact_form_submit', {
                    'event_category': 'engagement'
                });
            },
            // Ver horarios
            verHorarios: function() {
                trackEvent('view_schedule', {
                    'event_category': 'content'
                });
            },
            // Ver evento
            verEvento: function(eventoNombre) {
                trackEvent('view_item', {
                    'event_category': 'events',
                    'item_name': eventoNombre
                });
            },
            // Ver noticia
            verNoticia: function(noticiaTitulo) {
                trackEvent('view_item', {
                    'event_category': 'news',
                    'item_name': noticiaTitulo
                });
            }
        };
    </script>
@endif

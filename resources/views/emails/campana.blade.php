<x-mail::message>
{!! $contenido !!}

<x-mail::panel>
Este mensaje fue enviado a {{ $fiel->email }} por {{ config('app.name') }}.

<x-mail::button :url="$fiel->url_preferencias" color="primary">
Gestionar preferencias
</x-mail::button>

<small style="display: block; margin-top: 10px; color: #6b7280;">
Si no deseas recibir más comunicaciones, puedes
<a href="{{ $fiel->url_cancelar_suscripcion }}" style="color: #6b7280;">cancelar tu suscripción</a>.
</small>
</x-mail::panel>

Atentamente,<br>
{{ config('app.name') }}
</x-mail::message>

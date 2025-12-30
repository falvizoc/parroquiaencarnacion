<x-mail::message>
{!! $contenido !!}

<x-mail::panel>
Este mensaje fue enviado a {{ $fiel->email }} por {{ config('app.name') }}.

Si no deseas recibir más comunicaciones, puedes actualizar tus preferencias de suscripción
respondiendo a este correo.
</x-mail::panel>

Atentamente,<br>
{{ config('app.name') }}
</x-mail::message>

<x-mail::message>
# ¡Bienvenido(a) a nuestra comunidad, {{ $nombre }}!

Gracias por registrarte en la Parroquia Nuestra Señora de la Encarnación.

Para completar tu registro y comenzar a recibir nuestras comunicaciones, por favor verifica tu correo electrónico haciendo clic en el siguiente botón:

<x-mail::button :url="$urlVerificacion" color="primary">
Verificar mi correo electrónico
</x-mail::button>

**¿Por qué verificar?**

- Recibirás nuestro boletín parroquial
- Te mantendremos informado de eventos y actividades
- Podrás participar en nuestra comunidad digital

Si no creaste esta cuenta, puedes ignorar este mensaje.

---

**¿Tienes problemas con el botón?**

Copia y pega el siguiente enlace en tu navegador:

{{ $urlVerificacion }}

---

Con bendiciones,<br>
**{{ config('app.name') }}**

<x-mail::subcopy>
Este enlace de verificación expirará en 7 días. Si necesitas un nuevo enlace, puedes solicitarlo desde nuestra página de registro.
</x-mail::subcopy>
</x-mail::message>

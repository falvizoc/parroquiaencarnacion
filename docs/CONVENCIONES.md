# Convenciones y Principios del Proyecto

Este documento es el eje conductor del proyecto. Debe consultarse ante cualquier
duda para mantener la coherencia en todo el desarrollo.

## Idioma

- **Documentación**: Español
- **Comentarios en código**: Español
- **Variables y funciones**: Español (snake_case para PHP, camelCase para JS)
- **Nombres de archivos**: Inglés (convención Laravel)
- **Commits**: Español
- **Mensajes al usuario**: Español/Inglés (según idioma seleccionado)

## Convenciones de Nombres

### PHP/Laravel

```php
// Variables: snake_case en español
$horario_misa = '';
$nombre_grupo = '';
$fecha_evento = '';

// Funciones/Métodos: camelCase en español
public function obtenerHorarios() {}
public function crearEvento() {}
public function enviarNotificacion() {}

// Clases: PascalCase en inglés (convención Laravel)
class MassSchedule extends Model {}
class EventController extends Controller {}

// Constantes: UPPER_SNAKE_CASE
const ESTADO_ACTIVO = 'activo';
const TIPO_MISA_DOMINICAL = 'dominical';
```

### Base de Datos

```sql
-- Tablas: plural, snake_case, inglés
mass_schedules
parish_groups
faithful_members

-- Columnas: snake_case, español semántico
nombre
descripcion
fecha_inicio
hora_inicio
esta_activo
creado_en (created_at se mantiene en inglés por Laravel)

-- Llaves foráneas: tabla_singular_id
parish_group_id
event_id
```

### Frontend (Blade/JS)

```javascript
// Variables JS: camelCase
const horariosMisa = [];
const eventoSeleccionado = {};

// Componentes Blade: kebab-case
<x-horario-card />
<x-evento-modal />

// Clases CSS: kebab-case (Tailwind utilities + custom)
.tarjeta-evento {}
.boton-primario {}
```

### Archivos y Carpetas

```
app/
├── Models/              # PascalCase singular (inglés)
│   ├── MassSchedule.php
│   ├── ParishGroup.php
│   └── Event.php
├── Http/
│   ├── Controllers/     # PascalCase + Controller
│   │   ├── EventController.php
│   │   └── ContactController.php
│   └── Requests/        # PascalCase + Request
│       └── StoreEventRequest.php
├── Services/            # PascalCase + Service
│   ├── FacebookService.php
│   └── EmailService.php
└── Filament/
    └── Resources/       # PascalCase + Resource
        └── EventResource.php

resources/
├── views/
│   ├── components/      # kebab-case
│   │   └── horario-card.blade.php
│   └── pages/           # kebab-case
│       └── horarios.blade.php
└── lang/
    ├── es/              # Traducciones español
    └── en/              # Traducciones inglés
```

## Estructura de Carpetas

```
pencarnacion/
├── app/
│   ├── Models/          # Modelos Eloquent
│   ├── Http/
│   │   ├── Controllers/ # Controladores públicos
│   │   ├── Requests/    # Form Requests
│   │   └── Middleware/  # Middleware personalizado
│   ├── Services/        # Lógica de negocio
│   ├── Repositories/    # Acceso a datos (si aplica)
│   ├── Filament/        # Panel administrativo
│   │   ├── Resources/   # CRUD Resources
│   │   ├── Pages/       # Páginas custom
│   │   └── Widgets/     # Widgets dashboard
│   └── Enums/           # Enumeraciones
├── config/              # Configuraciones
├── database/
│   ├── migrations/      # Migraciones
│   ├── seeders/         # Seeders
│   └── factories/       # Factories para testing
├── docs/                # Documentación del proyecto
├── public/              # Assets públicos
├── resources/
│   ├── views/           # Vistas Blade
│   ├── css/             # Estilos
│   ├── js/              # JavaScript
│   └── lang/            # Traducciones
├── routes/              # Definición de rutas
├── storage/             # Archivos generados
└── tests/               # Pruebas
    ├── Unit/
    └── Feature/
```

## Patrones de Diseño

### Repository Pattern (Opcional)
Usar solo si la complejidad lo requiere. Para operaciones CRUD simples,
usar Eloquent directamente.

### Service Pattern
Encapsular lógica de negocio compleja en Services:

```php
// app/Services/FacebookService.php
class FacebookService
{
    public function publicarPost(string $mensaje, ?string $imagen = null): bool
    {
        // Lógica de publicación
    }

    public function obtenerPosts(int $limite = 10): Collection
    {
        // Lógica de obtención
    }
}
```

### Form Requests
Validación siempre en Form Requests, nunca en controladores:

```php
// app/Http/Requests/StoreEventRequest.php
class StoreEventRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date|after:today',
        ];
    }
}
```

## Manejo de Errores

### Respuestas de Error Estandarizadas

```php
// Errores de validación (422)
{
    "mensaje": "Los datos proporcionados no son válidos.",
    "errores": {
        "nombre": ["El campo nombre es obligatorio."]
    }
}

// Error no encontrado (404)
{
    "mensaje": "El recurso solicitado no fue encontrado."
}

// Error del servidor (500)
{
    "mensaje": "Ha ocurrido un error interno. Por favor, intente más tarde."
}
```

### Logging

```php
// Usar los niveles apropiados
Log::info('Fiel registrado', ['email' => $email]);
Log::warning('Intento de acceso fallido', ['ip' => $ip]);
Log::error('Error al conectar con Facebook', ['exception' => $e->getMessage()]);
```

## Formato de Respuestas API

### Respuesta Exitosa

```json
{
    "exito": true,
    "mensaje": "Operación completada exitosamente.",
    "datos": {
        // Datos solicitados
    },
    "meta": {
        "pagina_actual": 1,
        "total_paginas": 5,
        "total_registros": 50
    }
}
```

### Respuesta de Error

```json
{
    "exito": false,
    "mensaje": "Descripción del error.",
    "errores": {
        // Detalles específicos si aplica
    }
}
```

## Estilo de Código

### PHP (PSR-12 + Laravel Pint)

```php
<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Collection;

class EventService
{
    public function __construct(
        private readonly FacebookService $facebookService
    ) {}

    public function obtenerProximosEventos(int $limite = 5): Collection
    {
        return Event::query()
            ->where('fecha_inicio', '>=', now())
            ->where('esta_activo', true)
            ->orderBy('fecha_inicio')
            ->limit($limite)
            ->get();
    }
}
```

### JavaScript/Alpine.js

```javascript
// Usar const/let, nunca var
const eventos = [];
let eventoActual = null;

// Funciones flecha para callbacks
eventos.forEach((evento) => {
    console.log(evento.nombre);
});

// Alpine.js componentes
Alpine.data('calendario', () => ({
    eventos: [],
    eventoSeleccionado: null,

    async cargarEventos() {
        const respuesta = await fetch('/api/eventos');
        this.eventos = await respuesta.json();
    },

    seleccionarEvento(evento) {
        this.eventoSeleccionado = evento;
    }
}));
```

## Seguridad (OWASP)

1. **Inyección SQL**: Usar siempre Eloquent o Query Builder con bindings
2. **XSS**: Escapar output con `{{ }}`, usar `{!! !!}` solo cuando sea necesario
3. **CSRF**: Incluir `@csrf` en todos los formularios
4. **Autenticación**: Usar Laravel Sanctum/Fortify
5. **Autorización**: Implementar Policies para cada modelo
6. **Datos sensibles**: Nunca en logs ni respuestas de error
7. **Headers de seguridad**: Configurar en middleware
8. **Rate Limiting**: Aplicar a formularios y API

## SEO

1. Todas las páginas deben tener meta title y description únicos
2. Usar URLs semánticas y legibles
3. Implementar Schema.org para eventos, organización, FAQs
4. Imágenes con alt descriptivo
5. Estructura de encabezados jerárquica (h1 > h2 > h3)
6. Breadcrumbs en todas las páginas internas

## Accesibilidad (a11y)

1. Contraste mínimo 4.5:1 para texto
2. Navegación completa por teclado
3. Labels en todos los campos de formulario
4. Roles ARIA donde sea necesario
5. Skip links para navegación
6. Textos alternativos en imágenes

## UX/UI - Componentes Estándar

### Principio Frictionless

El diseño del panel administrativo sigue el principio **Frictionless**: reducir la
fricción cognitiva del usuario mediante navegación horizontal clara, agrupación
lógica de contenido y retroalimentación visual inmediata.

### Navegación por Tabs (Estándar Oficial)

Para páginas con múltiples secciones, usar el componente estándar `<x-admin.tabs>`:

```blade
{{-- Navegación por Tabs (usando componente estándar) --}}
<x-admin.tabs>
    {{-- Tab con ícono de marca (integraciones externas) --}}
    <x-admin.tabs.item :active="$activeTab === 'openai'" wire:click="setActiveTab('openai')">
        <x-slot:icon>
            <svg viewBox="0 0 24 24" fill="currentColor">...</svg>
        </x-slot:icon>
        OpenAI
    </x-admin.tabs.item>

    {{-- Tab con heroicon (secciones internas) --}}
    <x-admin.tabs.item :active="$activeTab === 'general'" wire:click="setActiveTab('general')">
        <x-slot:icon>
            <x-heroicon-o-cog-6-tooth class="h-5 w-5" />
        </x-slot:icon>
        General
    </x-admin.tabs.item>
</x-admin.tabs>
```

**Reglas de uso:**

| Contexto | Tipo de Ícono | Ejemplo |
|----------|---------------|---------|
| Integraciones externas | SVG oficial de marca | OpenAI, Google, Facebook |
| Secciones internas | Heroicons outline | Identidad, Configuración |
| Sin ícono claro | Omitir slot `icon` | - |

**Archivos del componente:**
- `resources/views/components/admin/tabs/index.blade.php` - Contenedor
- `resources/views/components/admin/tabs/item.blade.php` - Item individual

**Páginas que usan este estándar:**
- `Integraciones` - OpenAI, Google Analytics, Facebook
- `Apariencia` - Identidad, Hero, Adoración

### Estilos visuales del Tab

- **Fondo contenedor**: `rounded-xl bg-gray-100 dark:bg-gray-800 p-1`
- **Tab activo**: `bg-white dark:bg-gray-900 text-primary-600 shadow-sm`
- **Tab inactivo**: `text-gray-600 hover:bg-white/50`
- **Transición**: `transition-all duration-200`
- **Íconos**: `h-5 w-5` (20px)

## Testing

```php
// Nomenclatura de tests: test_[acción]_[condición]_[resultado_esperado]
public function test_crear_evento_con_datos_validos_guarda_en_base_de_datos(): void
{
    // Arrange
    $datos = Event::factory()->make()->toArray();

    // Act
    $respuesta = $this->post('/admin/eventos', $datos);

    // Assert
    $respuesta->assertRedirect();
    $this->assertDatabaseHas('events', ['nombre' => $datos['nombre']]);
}
```

## Control de Versiones

### Mensajes de Commit

```
[tipo]: descripción corta en español

Tipos:
- feat: nueva funcionalidad
- fix: corrección de bug
- docs: cambios en documentación
- style: cambios de formato (sin afectar código)
- refactor: refactorización de código
- test: añadir o modificar tests
- chore: tareas de mantenimiento

Ejemplos:
feat: agregar formulario de registro de fieles
fix: corregir validación de fecha en eventos
docs: actualizar guía de instalación
```

### Ramas

```
main            # Producción estable
develop         # Integración de features
feature/*       # Nuevas funcionalidades
bugfix/*        # Corrección de errores
release/*       # Preparación de versiones
hotfix/*        # Correcciones urgentes en producción
```

## Versionado Semántico

```
MAJOR.MINOR.PATCH

MAJOR: Cambios incompatibles con versiones anteriores
MINOR: Nueva funcionalidad compatible hacia atrás
PATCH: Correcciones de bugs compatibles

Ejemplos:
0.1.0 - Primera versión funcional (MVP)
0.2.0 - Agregar módulo de eventos
0.2.1 - Corregir bug en calendario
1.0.0 - Versión estable de producción
```

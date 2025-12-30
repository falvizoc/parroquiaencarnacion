# Parroquia Nuestra Señora de la Encarnación

Sitio web oficial de la Parroquia Nuestra Señora de la Encarnación en Tampico, Tamaulipas, México.

## Stack Tecnológico

| Tecnología | Versión | Uso |
|------------|---------|-----|
| Laravel | 12.x | Framework PHP |
| Filament | 3.x | Panel de administración |
| Livewire | 3.x | Componentes reactivos |
| Tailwind CSS | 4.x | Estilos |
| MySQL | 8.x | Base de datos |

## Requisitos

- PHP 8.2+
- Composer 2.x
- Node.js 18+
- MySQL 8.x

## Instalación

```bash
# Clonar repositorio
git clone git@github.com:falvizoc/parroquiaencarnacion.git
cd parroquiaencarnacion

# Instalar dependencias PHP
composer install

# Instalar dependencias Node
npm install

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Configurar base de datos en .env
# DB_DATABASE=parroquia_encarnacion
# DB_USERNAME=tu_usuario
# DB_PASSWORD=tu_password

# Ejecutar migraciones y seeders
php artisan migrate --seed

# Crear usuario administrador
php artisan make:filament-user
```

## Desarrollo

```bash
# Servidor Laravel
php artisan serve

# Compilar assets (Vite + Tailwind)
npm run dev

# Build para producción
npm run build
```

## URLs

| Ambiente | URL |
|----------|-----|
| Sitio público (ES) | http://localhost:8000/es |
| Sitio público (EN) | http://localhost:8000/en |
| Panel Admin | http://localhost:8000/admin |

## Estructura del Proyecto

```
app/
├── Filament/Resources/    # CRUD del panel admin
├── Models/                # Modelos Eloquent
└── Http/Middleware/       # Middleware (i18n)

resources/
├── views/pages/           # Vistas públicas
├── lang/{es,en}/          # Traducciones
└── css/app.css            # Estilos Tailwind

docs/                      # Documentación del proyecto
├── PROYECTO.md            # Información general
├── CONVENCIONES.md        # Estándares de código
├── MILESTONES.md          # Plan de desarrollo
├── SESION.md              # Estado actual
└── CHANGELOG.md           # Registro de cambios
```

## Módulos Implementados

### Fase 1: Núcleo Informativo
- [x] Layout público (header, footer, navegación)
- [x] Página de inicio
- [x] Horarios de misa
- [x] Página de contacto
- [x] Adoración perpetua
- [x] Registro de fieles
- [x] SEO (meta tags, Open Graph, Schema.org)

### Fase 2: Contenido Dinámico
- [x] Grupos Parroquiales (CRUD + vistas públicas)
- [x] Sistema de Eventos (CRUD + vistas públicas)
- [x] Sistema de Noticias (CRUD + vistas públicas)
- [x] Sistema de Capillas (con horarios y grupos)
- [x] Sistema de Sacerdotes (párroco + vicarios)
- [ ] Integración Facebook

### Fase 3-6: En planificación
Ver `docs/MILESTONES.md` para el plan completo.

## Convenciones

- **Variables PHP**: `snake_case` en español
- **Funciones PHP**: `camelCase` en español
- **Clases**: `PascalCase` en inglés (Laravel)
- **Commits**: `[tipo]: descripción en español`

## Idiomas

El sitio soporta español (default) e inglés. Todas las rutas públicas usan el prefijo `/{locale}/`.

## Licencia

Proyecto privado - Todos los derechos reservados.

## Contacto

Parroquia Nuestra Señora de la Encarnación
Tampico, Tamaulipas, México
https://parroquiaencarnaciontampico.org

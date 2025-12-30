# Claude Code - Parroquia Encarnación

## Información del Proyecto

| Campo | Valor |
|-------|-------|
| **Proyecto** | Sitio web Parroquia Nuestra Señora de la Encarnación |
| **Stack** | Laravel 12 + Filament 3 + Livewire + Tailwind CSS 4 |
| **Idioma código** | Español (variables, funciones, comentarios) |
| **Idiomas sitio** | Español (default), Inglés |
| **Base de datos** | MySQL |
| **Ambiente** | Verificar `APP_ENV` en `.env` |

## Protocolo de Sesión

### Al iniciar sesión ("iniciamos el día")
1. Leer `docs/SESION.md` - Estado actual del proyecto
2. Leer `docs/MILESTONES.md` - Tareas pendientes
3. Ejecutar `git status` y `git branch`
4. Reportar estado al usuario

### Al cerrar sesión ("cierra el día")
1. Actualizar `docs/SESION.md` con progreso
2. Actualizar `docs/CHANGELOG.md` si hubo cambios significativos
3. Commit de cambios pendientes
4. Push a GitHub (si está configurado)

### Si pierdo contexto
Leer en orden: `CLAUDE.md` → `docs/PROYECTO.md` → `docs/SESION.md`

## Documentación del Proyecto

| Archivo | Contenido |
|---------|-----------|
| `docs/PROYECTO.md` | Información general, objetivos, módulos |
| `docs/CONVENCIONES.md` | **Consultar siempre** - Estándares de código |
| `docs/CHANGELOG.md` | Registro de cambios y bugs |
| `docs/SESION.md` | Estado actual, progreso, bloqueos |
| `docs/MILESTONES.md` | Plan de desarrollo, tareas por fase |

## Comandos Frecuentes

```bash
# Desarrollo
php artisan serve          # Servidor Laravel (puerto 8000)
npm run dev                # Vite + Tailwind
php artisan migrate        # Ejecutar migraciones
php artisan make:filament-user  # Crear usuario admin

# Filament
php artisan make:filament-resource NombreModelo
php artisan make:filament-page NombrePagina
php artisan make:filament-widget NombreWidget

# Testing
php artisan test           # Ejecutar tests
php artisan test --filter=NombreTest

# Caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Estructura de Carpetas Clave

```
app/
├── Filament/Resources/    # CRUD del panel admin
├── Http/Middleware/       # SetLocale para i18n
├── Models/                # Modelos Eloquent
└── Services/              # Lógica de negocio

resources/
├── views/pages/           # Vistas públicas
├── lang/{es,en}/          # Traducciones
└── css/app.css            # Tailwind + estilos custom

docs/                      # Documentación del proyecto
```

## Convenciones Críticas

### Nomenclatura
- **Variables PHP**: `snake_case` en español (`$horario_misa`)
- **Funciones PHP**: `camelCase` en español (`obtenerHorarios()`)
- **Clases**: `PascalCase` en inglés (convención Laravel)
- **Archivos Blade**: `kebab-case` (`horario-card.blade.php`)

### Commits
```
[tipo]: descripción en español

Tipos: feat, fix, docs, style, refactor, test, chore
```

### Rutas con idioma
Todas las rutas públicas usan prefijo `/{locale}/` donde locale es `es` o `en`.

## Restricciones

- **NO** modificar archivos en `vendor/` o `node_modules/`
- **NO** commitear `.env` (usar `.env.example`)
- **NO** ejecutar migraciones destructivas sin confirmar
- **NO** push a `main` directamente (usar `develop` → PR → `main`)
- **Siempre** consultar `docs/CONVENCIONES.md` ante dudas de estilo

## URLs del Proyecto

| Ambiente | URL |
|----------|-----|
| Local | http://localhost:8000 |
| Admin | http://localhost:8000/admin |
| Producción | https://parroquiaencarnaciontampico.org |

## Contacto y Recursos

- **Repositorio**: (configurar GitHub)
- **Producción**: cPanel en dominio del cliente
- **Documentación Laravel**: https://laravel.com/docs
- **Documentación Filament**: https://filamentphp.com/docs

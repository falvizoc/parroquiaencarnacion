# Milestones del Proyecto

Plan de desarrollo MVP para el sitio web de la Parroquia Nuestra Señora de la Encarnación.

## Resumen de Fases

| Fase | Nombre | Estado | Progreso |
|------|--------|--------|----------|
| 0 | Fundación | Completado | 100% |
| 1 | Núcleo Informativo | Pendiente | 0% |
| 2 | Contenido Dinámico | Pendiente | 0% |
| 3 | Comunidad | Pendiente | 0% |
| 4 | Optimización y Calidad | Pendiente | 0% |
| 5 | Preparación Producción | Pendiente | 0% |
| 6 | Post-MVP | Futuro | 0% |

---

## Fase 0: Fundación

**Objetivo:** Establecer la base técnica del proyecto.

### M0.1 - Configuración Inicial
| Tarea | Estado | Notas |
|-------|--------|-------|
| Crear proyecto Laravel 11 | Completado | Laravel 12.44.0 |
| Configurar estructura de carpetas | Completado | Estructura estándar Laravel |
| Crear documentación base | Completado | docs/ |
| Configurar .env para desarrollo | Completado | MySQL, timezone MX |
| Configurar .gitignore | Completado | |

### M0.2 - Base de Datos
| Tarea | Estado | Notas |
|-------|--------|-------|
| Diseñar esquema de BD | Pendiente | Para Fase 1 |
| Crear migraciones base | Completado | Migraciones Laravel por defecto |
| Crear seeders iniciales | Pendiente | Para Fase 1 |
| Configurar conexión MySQL | Completado | En .env |

### M0.3 - Autenticación
| Tarea | Estado | Notas |
|-------|--------|-------|
| Instalar Filament 3 | Completado | v3.3.45 |
| Configurar panel admin | Completado | /admin |
| Crear roles (párroco, secretaría, voluntario) | Pendiente | Para Fase 1 |
| Configurar permisos | Pendiente | Para Fase 1 |

### M0.4 - Internacionalización
| Tarea | Estado | Notas |
|-------|--------|-------|
| Configurar locales (es, en) | Completado | Español por defecto |
| Crear archivos de traducción base | Completado | resources/lang/ |
| Implementar URLs localizadas | Completado | /es/, /en/ |
| Middleware de detección de idioma | Completado | SetLocale middleware |

---

## Fase 1: Núcleo Informativo

**Objetivo:** Crear las páginas públicas básicas del sitio.

### M1.1 - Layout Público
| Tarea | Estado | Notas |
|-------|--------|-------|
| Crear layout base | Pendiente | |
| Implementar header con navegación | Pendiente | |
| Implementar footer | Pendiente | |
| Configurar Tailwind CSS | Pendiente | |
| Diseño responsive (mobile-first) | Pendiente | |
| Configurar meta tags SEO base | Pendiente | |

### M1.2 - Página de Inicio
| Tarea | Estado | Notas |
|-------|--------|-------|
| Hero section | Pendiente | |
| Horarios de misa destacados | Pendiente | |
| Próximos eventos | Pendiente | |
| Llamados a la acción (CTAs) | Pendiente | |
| Sección de bienvenida | Pendiente | |

### M1.3 - Horarios de Misa
| Tarea | Estado | Notas |
|-------|--------|-------|
| Modelo MassSchedule | Pendiente | |
| CRUD en Filament | Pendiente | |
| Vista pública de horarios | Pendiente | |
| Filtros por día/tipo | Pendiente | |

### M1.4 - Página de Contacto
| Tarea | Estado | Notas |
|-------|--------|-------|
| Formulario de contacto | Pendiente | |
| Validación | Pendiente | |
| Envío de email | Pendiente | |
| Mapa de ubicación | Pendiente | |
| Información de contacto | Pendiente | |

### M1.5 - Páginas Estáticas
| Tarea | Estado | Notas |
|-------|--------|-------|
| Adoración Perpetua | Pendiente | |
| Historia de la parroquia | Pendiente | |
| Información general | Pendiente | |
| Gestión desde admin | Pendiente | |

---

## Fase 2: Contenido Dinámico

**Objetivo:** Implementar sistemas de contenido gestionable.

### M2.1 - Grupos Parroquiales
| Tarea | Estado | Notas |
|-------|--------|-------|
| Modelo ParishGroup | Pendiente | |
| CRUD en Filament | Pendiente | |
| Listado público | Pendiente | |
| Página de detalle | Pendiente | |
| Horarios y actividades | Pendiente | |

### M2.2 - Sistema de Eventos
| Tarea | Estado | Notas |
|-------|--------|-------|
| Modelo Event | Pendiente | |
| CRUD en Filament | Pendiente | |
| Integración FullCalendar | Pendiente | |
| Vista de calendario | Pendiente | |
| Vista de lista | Pendiente | |
| Página de detalle | Pendiente | |
| Filtros y búsqueda | Pendiente | |

### M2.3 - Sistema de Noticias
| Tarea | Estado | Notas |
|-------|--------|-------|
| Modelo News | Pendiente | |
| CRUD en Filament | Pendiente | |
| Listado con paginación | Pendiente | |
| Página de detalle | Pendiente | |
| Categorías | Pendiente | |
| Imágenes destacadas | Pendiente | |

### M2.4 - Integración Facebook
| Tarea | Estado | Notas |
|-------|--------|-------|
| Configurar Facebook App | Pendiente | Requiere credenciales |
| FacebookService | Pendiente | |
| Importar posts | Pendiente | |
| Publicar desde admin | Pendiente | |
| Sincronización automática | Pendiente | |

---

## Fase 3: Comunidad

**Objetivo:** Implementar funcionalidades de comunidad y comunicación.

### M3.1 - Registro de Fieles
| Tarea | Estado | Notas |
|-------|--------|-------|
| Modelo FaithfulMember | Pendiente | |
| Formulario público de registro | Pendiente | |
| Validación de datos | Pendiente | |
| Confirmación por email | Pendiente | |
| Página de perfil | Pendiente | |

### M3.2 - Directorio de Fieles
| Tarea | Estado | Notas |
|-------|--------|-------|
| Vista en Filament | Pendiente | |
| Búsqueda y filtros | Pendiente | |
| Exportación (CSV, Excel) | Pendiente | |
| Gestión de datos | Pendiente | |

### M3.3 - Sistema de Comunicaciones
| Tarea | Estado | Notas |
|-------|--------|-------|
| Plantillas de email | Pendiente | |
| Envío masivo | Pendiente | |
| Segmentación | Pendiente | |
| Cola de envío (Queue) | Pendiente | |
| Historial de envíos | Pendiente | |

### M3.4 - Newsletter
| Tarea | Estado | Notas |
|-------|--------|-------|
| Suscripción opt-in | Pendiente | |
| Preferencias de comunicación | Pendiente | |
| Integración con comunicaciones | Pendiente | |
| Cancelar suscripción | Pendiente | |

---

## Fase 4: Optimización y Calidad

**Objetivo:** Optimizar para SEO, rendimiento y calidad.

### M4.1 - SEO Técnico
| Tarea | Estado | Notas |
|-------|--------|-------|
| Meta tags dinámicos | Pendiente | |
| Sitemap.xml | Pendiente | |
| Robots.txt | Pendiente | |
| Schema.org (JSON-LD) | Pendiente | |
| Open Graph / Twitter Cards | Pendiente | |
| Canonical URLs | Pendiente | |
| Breadcrumbs | Pendiente | |

### M4.2 - AEO (Answer Engine Optimization)
| Tarea | Estado | Notas |
|-------|--------|-------|
| FAQ Schema | Pendiente | |
| llms.txt | Pendiente | |
| Contenido estructurado Q&A | Pendiente | |
| Página de autor/about | Pendiente | |

### M4.3 - Performance
| Tarea | Estado | Notas |
|-------|--------|-------|
| Caché de vistas | Pendiente | |
| Optimización de imágenes | Pendiente | |
| Lazy loading | Pendiente | |
| Minificación CSS/JS | Pendiente | |
| Core Web Vitals | Pendiente | |

### M4.4 - Analítica
| Tarea | Estado | Notas |
|-------|--------|-------|
| Google Analytics 4 | Pendiente | |
| Google Search Console | Pendiente | |
| Eventos de conversión | Pendiente | |
| Dashboard de métricas | Pendiente | |

### M4.5 - Testing
| Tarea | Estado | Notas |
|-------|--------|-------|
| Tests unitarios | Pendiente | |
| Tests de integración | Pendiente | |
| Tests de Feature | Pendiente | |
| Cobertura mínima 70% | Pendiente | |

---

## Fase 5: Preparación Producción

**Objetivo:** Preparar el sitio para el lanzamiento.

### M5.1 - Seguridad
| Tarea | Estado | Notas |
|-------|--------|-------|
| Auditoría OWASP | Pendiente | |
| Headers de seguridad | Pendiente | |
| Rate limiting | Pendiente | |
| Configurar backups | Pendiente | |
| Revisión de permisos | Pendiente | |

### M5.2 - Despliegue cPanel
| Tarea | Estado | Notas |
|-------|--------|-------|
| Configurar dominio | Pendiente | |
| Instalar SSL | Pendiente | |
| Configurar .env producción | Pendiente | |
| Migrar base de datos | Pendiente | |
| Configurar cron jobs | Pendiente | |

### M5.3 - Documentación Usuario
| Tarea | Estado | Notas |
|-------|--------|-------|
| Manual de administrador | Pendiente | |
| Guía de uso del panel | Pendiente | |
| FAQ para voluntarios | Pendiente | |

### M5.4 - Go-Live
| Tarea | Estado | Notas |
|-------|--------|-------|
| Checklist pre-lanzamiento | Pendiente | |
| Verificación final | Pendiente | |
| Lanzamiento | Pendiente | |
| Monitoreo inicial | Pendiente | |

---

## Fase 6: Post-MVP (Futuro)

### M6.1 - Sistema de Donaciones
| Tarea | Estado | Notas |
|-------|--------|-------|
| Integración pasarela de pago | Futuro | OpenPay/Stripe |
| Formulario de donación | Futuro | |
| Recibos automáticos | Futuro | |
| Reportes de donaciones | Futuro | |

### M6.2 - PWA / App Móvil
| Tarea | Estado | Notas |
|-------|--------|-------|
| Service Worker | Futuro | |
| Manifest.json | Futuro | |
| Notificaciones push | Futuro | |
| Modo offline | Futuro | |

### M6.3 - Transmisiones en Vivo
| Tarea | Estado | Notas |
|-------|--------|-------|
| Integración YouTube Live | Futuro | |
| Integración Facebook Live | Futuro | |
| Página de transmisión | Futuro | |

---

## Métricas de Progreso

### Por Fase

```
Fase 0: ██████████ 100% ✓
Fase 1: ░░░░░░░░░░ 0%
Fase 2: ░░░░░░░░░░ 0%
Fase 3: ░░░░░░░░░░ 0%
Fase 4: ░░░░░░░░░░ 0%
Fase 5: ░░░░░░░░░░ 0%
```

### General MVP

```
Progreso total: ███░░░░░░░░░░░░░░░░░ ~15%
```

---

## Dependencias Externas

| Dependencia | Fase | Estado | Responsable |
|-------------|------|--------|-------------|
| Credenciales Facebook API | 2.4 | Pendiente | Cliente |
| Cuenta Google Analytics | 4.4 | Pendiente | Cliente |
| Contenido (textos, imágenes) | 1-2 | Pendiente | Cliente |
| Acceso cPanel | 5.2 | Disponible | Cliente |
| Certificado SSL | 5.2 | Verificar | Cliente |

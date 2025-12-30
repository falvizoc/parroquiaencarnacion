# Milestones del Proyecto

Plan de desarrollo MVP para el sitio web de la Parroquia Nuestra Señora de la Encarnación.

## Resumen de Fases

| Fase | Nombre | Estado | Progreso |
|------|--------|--------|----------|
| 0 | Fundación | Completado | 100% |
| 1 | Núcleo Informativo | Completado | 100% |
| 2 | Contenido Dinámico | Completado | 100% |
| 3 | Comunidad | Completado | 100% |
| 4 | Optimización y Calidad | En Progreso | 60% |
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
| Modelo ParishGroup | Completado | Con scopes y accessors |
| CRUD en Filament | Completado | ParishGroupResource |
| Listado público | Completado | pages/grupos/index.blade.php |
| Página de detalle | Completado | pages/grupos/detalle.blade.php |
| Horarios y actividades | Completado | Incluido en modelo y vistas |

### M2.2 - Sistema de Eventos
| Tarea | Estado | Notas |
|-------|--------|-------|
| Modelo Event | Completado | Con scopes y accessors |
| CRUD en Filament | Completado | EventResource |
| Integración FullCalendar | Pendiente | Para M2.4 opcional |
| Vista de calendario | Completado | Badges de fecha en cards |
| Vista de lista | Completado | pages/eventos/index.blade.php |
| Página de detalle | Completado | pages/eventos/detalle.blade.php |
| Filtros y búsqueda | Completado | En Filament |

### M2.3 - Sistema de Noticias
| Tarea | Estado | Notas |
|-------|--------|-------|
| Modelo News | Completado | Con scopes y accessors |
| CRUD en Filament | Completado | NewsResource |
| Listado con paginación | Completado | pages/noticias/index.blade.php |
| Página de detalle | Completado | pages/noticias/detalle.blade.php |
| Categorías | Completado | parroquia, diocesis, papa, comunidad, general |
| Imágenes destacadas | Completado | FileUpload con resize |

### M2.4 - Sistema de Capillas
| Tarea | Estado | Notas |
|-------|--------|-------|
| Modelo Chapel | Completado | Con relaciones a MassSchedule y ParishGroup |
| CRUD en Filament | Completado | ChapelResource |
| Listado público | Completado | pages/capillas/index.blade.php |
| Página de detalle | Completado | Con horarios y grupos de la capilla |
| Actualizar MassSchedule | Completado | Relación belongsTo Chapel |
| Actualizar ParishGroup | Completado | Relación belongsTo Chapel |

### M2.5 - Sistema de Sacerdotes
| Tarea | Estado | Notas |
|-------|--------|-------|
| Modelo Priest | Completado | Validación de único párroco |
| CRUD en Filament | Completado | PriestResource |
| Vista pública | Completado | pages/sacerdotes.blade.php |
| Mensaje personal | Completado | RichEditor en Filament |
| Foto y biografía | Completado | FileUpload con resize 3:4 |

### M2.6 - Integración Facebook
| Tarea | Estado | Notas |
|-------|--------|-------|
| Modelo Setting (config encriptada) | Completado | Credenciales en BD |
| Página de Integraciones en admin | Completado | Panel > Configuración > Integraciones |
| FacebookService | Completado | Lee config de BD |
| Configurar Facebook App | En Producción | Usuario configura desde panel |
| Importar posts | Pendiente | Cuando haya credenciales |
| Widget de posts en sitio público | Pendiente | Cuando haya credenciales |

---

## Fase 3: Comunidad

**Objetivo:** Implementar funcionalidades de comunidad y comunicación.

### M3.1 - Registro de Fieles
| Tarea | Estado | Notas |
|-------|--------|-------|
| Modelo FaithfulMember | Completado | Con relaciones, scopes y accessors |
| Formulario público de registro | Completado | Livewire paso a paso (3 pasos) |
| Validación de datos | Completado | Validación por paso |
| Confirmación por email | Completado | Mailable + VerificacionController |
| Página de perfil | Pendiente | |

### M3.2 - Directorio de Fieles
| Tarea | Estado | Notas |
|-------|--------|-------|
| Vista en Filament | Completado | FaithfulMemberResource con tabs |
| Búsqueda y filtros | Completado | Estado, verificación, capilla, género |
| Exportación (CSV, Excel) | Completado | Campos configurables, filtros |
| Gestión de datos | Completado | CRUD completo con soft deletes |

### M3.3 - Sistema de Comunicaciones
| Tarea | Estado | Notas |
|-------|--------|-------|
| Plantillas de email | Completado | EmailTemplate con variables dinámicas |
| Envío masivo | Completado | EnviarCampanaEmail Job |
| Segmentación | Completado | Newsletter, eventos, avisos, capilla |
| Cola de envío (Queue) | Completado | Job con queue |
| Historial de envíos | Completado | EmailLog + LogsRelationManager |

### M3.4 - Newsletter
| Tarea | Estado | Notas |
|-------|--------|-------|
| Suscripción opt-in | Completado | SuscripcionNewsletter Livewire |
| Preferencias de comunicación | Completado | GestionPreferencias con token |
| Integración con comunicaciones | Completado | Variables en templates |
| Cancelar suscripción | Completado | Un clic con token |

### M3.5 - Servicios Adicionales (Criptas)
| Tarea | Estado | Notas |
|-------|--------|-------|
| Modelo CryptInfo | Completado | Información general de criptas |
| Modelo CryptCampaign | Completado | Campañas estacionales |
| CRUD en Filament | Completado | Grupo "Servicios" |
| Sección en inicio | Completado | Con banner de campaña |
| Activación automática | Completado | Por fechas inicio/fin |
| Seeder de datos | Completado | CryptSeeder |

---

## Fase 4: Optimización y Calidad

**Objetivo:** Optimizar para SEO, rendimiento y calidad.

### M4.1 - SEO Técnico
| Tarea | Estado | Notas |
|-------|--------|-------|
| Meta tags dinámicos | Completado | SeoService + View Composer |
| Sitemap.xml | Completado | Dinámico con SitemapController |
| Robots.txt | Completado | Bloqueo admin/livewire |
| Schema.org (JSON-LD) | Completado | Church, NewsArticle, Event |
| Open Graph / Twitter Cards | Completado | Integrado en layout |
| Canonical URLs | Completado | Automático en layout |
| Breadcrumbs | Completado | Componente con Schema.org |

### M4.2 - AEO (Answer Engine Optimization)
| Tarea | Estado | Notas |
|-------|--------|-------|
| FAQ Schema | Completado | Componente x-faq con FAQPage |
| llms.txt | Completado | Información estructurada para AI |
| Contenido estructurado Q&A | Completado | FAQs en página nosotros |
| Página de autor/about | Completado | /nosotros con E-E-A-T |

### M4.3 - Performance
| Tarea | Estado | Notas |
|-------|--------|-------|
| Caché de vistas | Completado | CacheControl middleware + app:optimizar |
| Optimización de imágenes | Completado | Componente x-imagen optimizado |
| Lazy loading | Completado | loading=lazy nativo + fetchpriority |
| Minificación CSS/JS | Completado | Vite + Terser en producción |
| Core Web Vitals | Completado | Preconnect, DNS prefetch, theme-color |

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

### M6.1 - Sistema de Intenciones de Misa
| Tarea | Estado | Notas |
|-------|--------|-------|
| Modelo MassIntention | Futuro | Con relaciones a MassSchedule y Chapel |
| Formulario público de solicitud | Futuro | Selección de horario/capilla |
| Tipos de intención | Futuro | Individual, triduo, recurrente (diario/semanal) |
| Validación de disponibilidad | Futuro | Hasta 1 hora antes de la misa |
| Límite de recurrencia | Futuro | Máximo 1 mes |
| Integración pasarela de pago | Futuro | Stripe/OpenPay/Conekta |
| Donativos recurrentes | Futuro | Suscripciones para intenciones periódicas |
| CRUD en Filament | Futuro | Para administradores |
| Registro manual (oficina) | Futuro | Intenciones solicitadas presencialmente |
| Calendario de intenciones | Futuro | Vista por día/semana/mes |
| Generación de PDF | Futuro | Comprobantes e impresión |
| Notificaciones email | Futuro | Confirmación y recordatorios |
| Reportes de intenciones | Futuro | Por período, capilla, tipo |

### M6.2 - Sistema de Donaciones Generales
| Tarea | Estado | Notas |
|-------|--------|-------|
| Formulario de donación única | Futuro | Donaciones sin intención |
| Donaciones recurrentes | Futuro | Suscripciones mensuales |
| Recibos automáticos | Futuro | PDF por email |
| Reportes de donaciones | Futuro | Dashboard financiero |

### M6.4 - PWA / App Móvil
| Tarea | Estado | Notas |
|-------|--------|-------|
| Service Worker | Futuro | |
| Manifest.json | Futuro | |
| Notificaciones push | Futuro | |
| Modo offline | Futuro | |

### M6.5 - Transmisiones en Vivo
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
Fase 1: ██████████ 100% ✓
Fase 2: ██████████ 100% ✓
Fase 3: ██████████ 100% ✓
Fase 4: ██████░░░░ 60%
Fase 5: ░░░░░░░░░░ 0%
```

### General MVP

```
Progreso total: ██████████████████░░ ~92%
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

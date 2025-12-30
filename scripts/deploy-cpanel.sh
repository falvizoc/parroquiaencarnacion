#!/bin/bash
# =====================================================
# Script de Despliegue para cPanel
# Parroquia Nuestra Señora de la Encarnación
# =====================================================
# Uso: ./scripts/deploy-cpanel.sh
# =====================================================

set -e  # Salir si hay errores

echo "========================================"
echo "Iniciando despliegue en producción..."
echo "========================================"

# --- 1. Verificar que estamos en producción ---
if [ "$APP_ENV" != "production" ]; then
    echo "ADVERTENCIA: APP_ENV no es 'production'"
    read -p "¿Continuar de todos modos? (s/n): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Ss]$ ]]; then
        echo "Despliegue cancelado."
        exit 1
    fi
fi

# --- 2. Modo mantenimiento ---
echo "Activando modo mantenimiento..."
php artisan down --render="errors::503" --retry=60

# --- 3. Actualizar código ---
echo "Actualizando código desde Git..."
git pull origin main

# --- 4. Instalar dependencias ---
echo "Instalando dependencias de Composer..."
composer install --no-dev --optimize-autoloader

# --- 5. Compilar assets ---
echo "Compilando assets..."
npm ci
npm run build

# --- 6. Limpiar y optimizar cachés ---
echo "Optimizando para producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan icons:cache

# --- 7. Ejecutar migraciones ---
echo "Ejecutando migraciones..."
php artisan migrate --force

# --- 8. Limpiar caché de aplicación ---
echo "Limpiando caché de aplicación..."
php artisan cache:clear

# --- 9. Optimizar storage ---
echo "Verificando storage link..."
php artisan storage:link 2>/dev/null || true

# --- 10. Permisos (ajustar según cPanel) ---
echo "Ajustando permisos..."
chmod -R 755 storage bootstrap/cache
chmod -R 644 storage/logs/*.log 2>/dev/null || true

# --- 11. Desactivar modo mantenimiento ---
echo "Desactivando modo mantenimiento..."
php artisan up

echo "========================================"
echo "¡Despliegue completado exitosamente!"
echo "========================================"
echo ""
echo "Verificaciones post-despliegue:"
echo "  1. Visitar: https://parroquiaencarnaciontampico.org"
echo "  2. Verificar panel admin: /admin"
echo "  3. Revisar logs: storage/logs/laravel.log"
echo ""

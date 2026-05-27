#!/bin/sh
set -e

# Solo usar .env como fallback, no como fuente principal
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Limpiar caches anteriores (del build time que pudieran haber quedado)
php artisan optimize:clear || true

# Cachear AHORA que las env vars del proceso ya están disponibles
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec /usr/bin/supervisord -c /etc/supervisord.conf

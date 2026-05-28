#!/bin/sh

# Crear .env si no existe
if [ ! -f .env ]; then
    cp .env.example .env
fi

echo "APP_KEY=$APP_KEY"
# Inyectar variables de entorno
sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}" .env

php artisan optimize:clear || true
php artisan config:cache || true
php artisan view:cache || true

exec /usr/bin/supervisord -c /etc/supervisord.conf

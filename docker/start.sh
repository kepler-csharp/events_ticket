#!/bin/sh

if [ ! -f .env ]; then
    cp .env.example .env
fi

# Remover entradas previas
sed -i '/^APP_ENV=/d' .env
sed -i '/^APP_KEY=/d' .env
sed -i '/^APP_URL=/d' .env

# Agregar variables runtime
echo "APP_ENV=${APP_ENV}" >> .env
echo "APP_KEY=${APP_KEY}" >> .env
echo "APP_URL=${APP_URL}" >> .env

php artisan optimize:clear || true
php artisan config:cache || true
php artisan view:cache || true

exec /usr/bin/supervisord -c /etc/supervisord.conf

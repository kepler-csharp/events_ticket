#!/bin/sh

if [ ! -f .env ]; then
    cp .env.example .env
fi

# Sobrescribir variables del contenedor
sed -i "s|^APP_ENV=.*|APP_ENV=${APP_ENV}|" .env
sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" .env
sed -i "s|^APP_URL=.*|APP_URL=${APP_URL}|" .env

php artisan optimize:clear || true
php artisan config:cache || true
php artisan view:cache || true

exec /usr/bin/supervisord -c /etc/supervisord.conf

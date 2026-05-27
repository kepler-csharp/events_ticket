#!/bin/sh

php artisan optimize:clear || true
php artisan config:cache || true
php artisan view:cache || true

exec /usr/bin/supervisord -c /etc/supervisord.conf

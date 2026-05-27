# Build stage
FROM php:8.3-fpm-alpine AS build

WORKDIR /app

RUN apk add --no-cache \
    curl git zip unzip \
    libpng-dev libjpeg-turbo-dev freetype-dev \
    libzip-dev openssl-dev nodejs npm

RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install \
    pdo pdo_mysql gd zip bcmath

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer

COPY . .

RUN composer install \
    --no-interaction \
    --no-dev \
    --prefer-dist \
    --optimize-autoloader

RUN npm install
RUN npm run build

# Runtime
FROM php:8.3-fpm-alpine

WORKDIR /app

RUN apk add --no-cache \
    nginx supervisor \
    libpng libjpeg-turbo freetype libzip \
    libpng-dev libjpeg-turbo-dev freetype-dev libzip-dev openssl-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install \
    pdo pdo_mysql gd zip bcmath opcache

COPY --from=build /app /app

COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf

RUN cp .env.example .env && \
    php artisan key:generate && \
    echo "SESSION_DRIVER=file" >> .env && \
    echo "CACHE_STORE=file" >> .env && \
    mkdir -p storage/logs bootstrap/cache /run/nginx && \
    chown -R www-data:www-data /app && \
    chmod -R 775 storage bootstrap/cache && \
    php artisan config:clear && \
    php artisan route:clear

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]

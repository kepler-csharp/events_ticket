# Section #1: Build
FROM php:8.3-fpm-alpine AS build

WORKDIR /app

# Instalar dependencias del sistema
RUN apk add --no-cache \
    curl \
    git \
    zip \
    unzip \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    openssl-dev

# Instalar extensiones de PHP necesarias
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    gd \
    zip \
    bcmath

# Instalar Composer (gestor de dependencias de PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . ./

# Instalar dependencias de PHP
RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

RUN composer dump-autoload --optimize

# Dar permisos al directorio de almacenamiento
RUN mkdir -p storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Section 2: Runtime

FROM php:8.3-fpm-alpine

WORKDIR /app

# Instalar dependencias de desarrollo
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    openssl-dev

# Instalar extensiones de PHP (reducidas, solo las necesarias)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    gd \
    zip \
    bcmath \
    opcache

# Instalar dependencias mínimas para runtime
RUN apk add --no-cache \
    libpng \
    libjpeg-turbo \
    freetype \
    libzip \
    nginx \
    supervisor

# Copiar desde la etapa build
COPY --from=build /app /app

# Copiar configuración de Nginx
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Copiar configuración de Supervisor
COPY docker/supervisord.conf /etc/supervisord.conf

# Crear .env automaticamente
RUN cp .env.example .env

# Generar APP_KEY automáticamente
RUN php artisan key:generate

# Forzar aplicación sin DB
RUN sed -i 's/SESSION_DRIVER=.*/SESSION_DRIVER=file/' .env || true && \
    sed -i 's/CACHE_STORE=.*/CACHE_STORE=file/' .env || true && \
    sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=null/' .env || true

# Dar permisos a laravel
RUN mkdir -p storage/logs bootstrap/cache /run/nginx && \
    chown -R www-data:www-data /app && \
    chmod -R 775 storage bootstrap/cache

# Limpiar caché de Laravel
RUN php artisan config:clear && \
    php artisan cache:clear && \
    php artisan route:clear

# Validar PHP-FPM config
RUN php-fpm -t

# Crear directorios necesarios
RUN mkdir -p /run/nginx

EXPOSE 80

# Comando de inicio
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]

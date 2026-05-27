# =========================
# BUILD STAGE
# =========================
FROM php:8.3-fpm-alpine AS build

WORKDIR /app

# Dependencias sistema
RUN apk add --no-cache \
    curl git zip unzip \
    nodejs npm \
    libpng-dev libjpeg-turbo-dev freetype-dev \
    libzip-dev oniguruma-dev

# Extensiones PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install \
    pdo \
    pdo_mysql \
    gd \
    zip \
    bcmath

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar composer primero (cache eficiente)
COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

# Copiar package files
COPY package*.json ./

RUN npm install

# Copiar app
COPY . .

# Build frontend
RUN npm run build

# Composer final (scripts después de copiar app)
RUN composer dump-autoload --optimize


# =========================
# RUNTIME STAGE
# =========================
FROM php:8.3-fpm-alpine

WORKDIR /app

ENV APP_ENV=production

# Runtime deps
RUN apk add --no-cache \
    nginx \
    supervisor \
    libpng \
    libjpeg-turbo \
    freetype \
    libzip

# PHP extensions
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install \
    pdo \
    pdo_mysql \
    gd \
    zip \
    bcmath \
    opcache

# Copiar app compilada
COPY --from=build /app /app

# Configs
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/start.sh /start.sh

RUN chmod +x /start.sh && \
    mkdir -p \
        storage/logs \
        bootstrap/cache \
        /run/nginx && \
    chown -R www-data:www-data /app && \
    chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD ["/start.sh"]

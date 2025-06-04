# Etapa 1: Instala dependências PHP (inclui Ziggy)
FROM composer:latest AS php-deps

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-scripts --no-interaction

# Etapa 2: Build Frontend com Vite (Node.js)
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

# Copia vendor (necessário para Ziggy funcionar no build)
COPY --from=php-deps /app/vendor ./vendor

RUN npm run build

# Etapa 3: PHP + Laravel com MongoDB + frontend compilado
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Instala driver MongoDB
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copia código fonte
COPY . .

# Copia vendor e build do frontend
COPY --from=php-deps /app/vendor ./vendor
COPY --from=node-builder /app/public/build ./public/build
COPY --from=node-builder /app/.vite ./.vite

# Gera cache Laravel
RUN composer dump-autoload --optimize && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Permissões corretas para storage
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

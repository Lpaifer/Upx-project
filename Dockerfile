# Etapa 1: Composer instala o PHP + Ziggy
FROM composer:latest AS php-deps

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist

# Etapa 2: Vite build (Node)
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

# Copia o vendor para o build Vite conseguir ler Ziggy
COPY --from=php-deps /app/vendor ./vendor

RUN npm run build

# Etapa 3: Laravel PHP com build finalizado
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

RUN pecl install mongodb && docker-php-ext-enable mongodb

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .
COPY --from=php-deps /app/vendor ./vendor
COPY --from=node-builder /app/public/build public/build
COPY --from=node-builder /app/.vite .vite/

RUN composer dump-autoload --optimize
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000

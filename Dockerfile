# Etapa 1: Build Frontend com Vite (Node.js)
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

RUN npm run build

# Etapa 2: PHP + Laravel com MongoDB + frontend compilado
FROM php:8.2-fpm

# Instala MongoDB e dependências PHP
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && pecl install mongodb && docker-php-ext-enable mongodb

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copia código
COPY . .

# Instala dependências PHP (agora com ext-mongodb já instalada!)
RUN composer install --no-dev --prefer-dist --no-scripts --no-interaction

# Copia build do frontend
COPY --from=node-builder /app/public/build ./public/build
COPY --from=node-builder /app/.vite ./.vite

# Otimizações e cache Laravel
RUN composer dump-autoload --optimize && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Permissões
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

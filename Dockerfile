# Etapa 1: Build Frontend com Vite (usando Node)
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# Etapa 2: Laravel com PHP + MongoDB
FROM php:8.2-fpm

# Instala dependências do sistema e do PHP
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Instala MongoDB PHP driver
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos da aplicação
COPY . .

# Copia o build do Vite gerado anteriormente
COPY --from=node-builder /app/public/build public/build
COPY --from=node-builder /app/.vite/ .vite/

# Instala dependências do Laravel
RUN composer install --optimize-autoloader --no-dev

# Gera cache
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Ajusta permissões
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

# Inicia Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000

# Etapa 1: Build Frontend (com Node.js)
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build

# Etapa 2: PHP + Laravel com Vite compilado
FROM php:8.2-fpm

# Instala dependências do sistema e PHP
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Instala driver do MongoDB
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cria diretório de trabalho
WORKDIR /var/www/html

# Copia do projeto
COPY . .

# Copia build do frontend gerado anteriormente
COPY --from=node-builder /app/public/build public/build
COPY --from=node-builder /app/.vite/ .vite/
COPY --from=node-builder /app/resources/js/ssr dist/ssr/

# Instala dependências Laravel
RUN composer install --optimize-autoloader --no-dev

# Gera cache e configurações Laravel
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Permissões
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000

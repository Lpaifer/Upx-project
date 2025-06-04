FROM php:8.2-fpm

# Instala dependências do sistema e do PHP
RUN apt-get update && apt-get install -y \
    libssl-dev pkg-config \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instala e ativa a extensão MongoDB com suporte SSL
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala Node.js (para o Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Define diretório de trabalho
WORKDIR /var/www

# Copia o projeto para dentro da imagem
COPY . .

# Instala dependências e prepara o app
RUN composer install --no-dev --prefer-dist && \
    npm install && \
    npm run build && \
    php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

# Inicia o servidor
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

FROM php:8.1-fpm

# Instalações necessárias
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo mbstring exif pcntl bcmath gd zip

# Instala MongoDB driver
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define diretório da aplicação
WORKDIR /var/www

# Copia tudo
COPY . .

# Instala dependências
RUN composer install --no-dev --optimize-autoloader

# Permissões
RUN chmod -R 775 storage bootstrap/cache

# Expõe a porta padrão
EXPOSE 8000

# Inicia a aplicação
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT}"]


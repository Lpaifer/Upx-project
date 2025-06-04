# Etapa 1: Builder PHP com extensões e Composer
FROM php:8.4-fpm as builder

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    libzip-dev \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libssl-dev \
    openssl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Instala extensões PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Copia o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia o projeto e instala dependências (cache e vendor já prontos!)
WORKDIR /var/www
COPY . .

RUN composer install --no-dev --prefer-dist \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Etapa 2: Build do Frontend com Vite
FROM node:20-alpine as node-builder

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

# Executa o build
RUN npm run build

# Etapa 3: Final com PHP + Vite build + Mongo + Supervisor
FROM php:8.4-fpm

# Instala dependências do sistema novamente (necessárias para rodar)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    nginx \
    supervisor \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Reinstala as extensões essenciais (compatíveis com o builder)
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Copia do builder
COPY --from=builder /usr/bin/composer /usr/bin/composer
COPY --from=builder /var/www /var/www

# Copia assets do Node
COPY --from=node-builder /app/public/build /var/www/public/build

# Define user
ARG user=laravel
ARG uid=1000
RUN useradd -G www-data,root -u ${uid} -d /home/${user} ${user} \
    && mkdir -p /home/${user}/.composer \
    && chown -R ${user}:${user} /home/${user}

# Permissões e logs
RUN mkdir -p /var/log/supervisor /var/www/storage/logs/supervisor \
    && chown -R laravel:www-data /var/log/supervisor /var/www/storage/logs \
    && chmod -R 775 /var/log/supervisor /var/www/storage/logs

WORKDIR /var/www

# Configuração do PHP-FPM
RUN echo "listen = 0.0.0.0:9000" >> /usr/local/etc/php-fpm.d/zz-docker.conf \
    && echo "clear_env = no" >> /usr/local/etc/php-fpm.d/zz-docker.conf

USER ${user}

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000

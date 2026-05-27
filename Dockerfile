FROM php:8.3-fpm

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev \
    libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install \
        pdo_mysql mbstring exif pcntl bcmath \
        gd zip opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Configuração PHP produção
COPY php.ini /usr/local/etc/php/conf.d/app.ini

WORKDIR /var/www

USER www-data

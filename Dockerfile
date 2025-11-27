FROM dunglas/frankenphp

ENV SERVER_NAME=:80
ENV APP_ROOT=/app

# Instalar dependencias necesarias para Laravel
RUN install-php-extensions \
    pdo_mysql \
    gd \
    intl \
    zip \
    opcache \
    bcmath \
    pcntl \
    redis

# Copiar el código
COPY . /app

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Permisos
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Comando de inicio
CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=80"]

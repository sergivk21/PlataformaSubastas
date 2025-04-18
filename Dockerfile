# Etapa de build: instala dependencias con Composer
FROM composer:2.7 AS build

WORKDIR /app

# Copia el código fuente
COPY . .

# Instala dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Etapa de producción: PHP con Apache
FROM php:8.2-apache

# Instala extensiones necesarias para Laravel y PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev libzip-dev unzip git \
    && docker-php-ext-install pdo pdo_pgsql zip

# Copia el código y dependencias desde la etapa de build
COPY --from=build /app /var/www/html

# Copia el archivo .env.example como .env si no existe
RUN if [ ! -f /var/www/html/.env ]; then cp /var/www/html/.env.example /var/www/html/.env; fi

# Da permisos a storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expone el puerto 80
EXPOSE 80

# Comando de inicio: genera clave, migra y arranca Apache
CMD php artisan key:generate --force && php artisan migrate --force && apache2-foreground

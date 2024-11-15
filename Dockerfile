# Dockerfile

# Usa una imagen oficial de PHP con Composer y Node.js preinstalados
FROM php:8.2-fpm

# Instala extensiones de PHP necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Instala Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala Node.js y npm
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Configuración de directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de Laravel al contenedor
COPY . .

# Instala dependencias de Composer
RUN composer install --no-interaction --optimize-autoloader --prefer-dist

# Instala dependencias de npm
RUN npm install && npm run build

# Da permisos al directorio storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exponer el puerto para Nginx
EXPOSE 9000

CMD ["php-fpm"]

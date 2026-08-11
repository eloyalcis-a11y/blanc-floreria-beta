FROM php:8.4-cli

# Instalar dependencias del sistema y Node.js para compilar los estilos
RUN apt-get update -y && apt-get install -y unzip git curl libsqlite3-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Instalar extensiones de PHP necesarias para Laravel
RUN docker-php-ext-install pdo pdo_sqlite

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Instalar dependencias de PHP y Node
RUN composer install --no-interaction --optimize-autoloader
RUN npm install && npm run build

# Exponer el puerto
EXPOSE 10000

# Comando para iniciar el servidor (Migramos y seedeamos en runtime)
CMD touch database/database.sqlite && php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=10000

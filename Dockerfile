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

# Preparar la base de datos SQLite y correr migraciones
RUN touch database/database.sqlite
RUN php artisan migrate --force
RUN php artisan db:seed --force

# Exponer el puerto
EXPOSE 10000

# Comando para iniciar el servidor
CMD php artisan serve --host=0.0.0.0 --port=10000

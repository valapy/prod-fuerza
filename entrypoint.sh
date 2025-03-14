#!/bin/bash

#Esperar a que la base de datos esté disponible
wait-for-it.sh marine-db:3306 --timeout=60 --strict -- echo "DB is up"

# Ejecutar composer install
echo "Running composer install..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# Generar la clave de la aplicación
echo "Generating application key..."
php artisan key:generate

# Ejecutar las migraciones
echo "Running migrations..."
php artisan migrate

# Ejecutar los seeders
echo "Running database seeders..."
php artisan db:seed

echo "Running npm install..."
npm install

# Ejecutar el proceso principal (php-fpm)
echo "Starting php-fpm..."
exec php-fpm

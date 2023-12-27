#!/bin/bash

# Esperar a que la base de datos esté lista (ajusta los parámetros según sea necesario)
# while ! nc -z db 3306; do
#   sleep 0.1
# done

# Ejecutar migraciones y seeders
php artisan migrate:fresh --seed

# Mantener en ejecución el proceso principal de Apache
apache2-foreground

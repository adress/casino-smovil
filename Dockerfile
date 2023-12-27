# Usar una imagen base de PHP con Apache, utilizando PHP 8.2
FROM php:8.2-apache

# Instalar las extensiones de PHP necesarias para Laravel
RUN apt-get update && apt-get install -y \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  zip \
  unzip \
  git \
  curl \
  libzip-dev \
  && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar Composer para gestionar las dependencias de PHP
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Habilitar mod_rewrite para Apache (necesario para las URLs amigables de Laravel)
RUN a2enmod rewrite

# Configurar el directorio raíz del servidor web para apuntar al directorio "public" de Laravel
RUN sed -i -e 's|/var/www/html|/var/www/public|g' /etc/apache2/sites-available/000-default.conf

# Establecer el directorio de trabajo
WORKDIR /var/www

# Copiar los archivos del proyecto Laravel al contenedor
COPY . /var/www

# Instalar las dependencias de Laravel con Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Cambiar la propiedad del directorio de almacenamiento para permitir que Apache escriba en él
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache


# # Copia el script al contenedor
# COPY wait-for-mysql.sh /usr/wait-for-mysql.sh
# RUN chmod +x /usr/wait-for-mysql.sh

# Configura el script como entrypoint
# ENTRYPOINT ["/usr/wait-for-mysql.sh", "mysql", "docker-php-entrypoint apache2-foreground"]

# Exponer el puerto 80
EXPOSE 80

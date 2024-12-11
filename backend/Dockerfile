# Usar la imagen oficial de PHP con extensiones necesarias para Laravel
FROM php:8.2-fpm

# Establecer directorio de trabajo
WORKDIR /var/www

# Instalar dependencias
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar archivos del backend al contenedor
COPY . /var/www

# Instalar las dependencias de Composer
RUN composer install

# Exponer el puerto 8000 para el backend
EXPOSE 8000

# Comando para ejecutar el servidor de Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0"]

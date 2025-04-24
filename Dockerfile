FROM php:8.3-apache

# Installe les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Active mod_rewrite (si besoin)
RUN a2enmod rewrite

# Copie les fichiers de ton projet
COPY . /var/www/html/

# Donne les bons droits
RUN chown -R www-data:www-data /var/www/html

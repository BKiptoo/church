# Dockerfile
#latest composer to get the dependencies
FROM composer:2.4.4 as build
WORKDIR /app
COPY . /app
RUN composer update --optimize-autoloader --no-dev
RUN php artisan optimize:clear

#PHP Apache docker image for php8.1
FROM php:8.2.0RC5-apache-buster
#adds library support for different image upload
RUN apt update && apt install -y zlib1g-dev libpng-dev libwebp-dev libjpeg-dev libfreetype6-dev && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_pgsql pcntl
#adds gd library support for different image upload
RUN docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype
RUN docker-php-ext-install gd

#000-default.conf is used to configure the web-server to listen to port 80 which Cloud run requires
EXPOSE 80
COPY --from=build /app /var/www/
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY .env.example /var/www/.env
RUN chmod 777 -R /var/www/storage/ && \
  echo "Listen 8080">>/etc/apache2/ports.conf && \
  chown -R www-data:www-data /var/www/ && \
  a2enmod rewrite

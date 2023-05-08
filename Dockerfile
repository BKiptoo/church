FROM composer:2.4.4 as build
WORKDIR /app
COPY . /app
RUN composer update --optimize-autoloader --no-dev
RUN php artisan optimize:clear

FROM php:8.2.0RC5-apache-buster
RUN docker-php-ext-install pdo pdo_mysql pcntl gd

EXPOSE 8080
COPY --from=build /app /var/www/
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY .env.example /var/www/.env
RUN chmod 777 -R /var/www/storage/ && \
    echo "Listen 8080" >> /etc/apache2/ports.conf && \
    chown -R www-data:www-data /var/www/ && \
    a2enmod rewrite

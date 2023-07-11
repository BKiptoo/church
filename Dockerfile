FROM php:8.2-fpm

LABEL maintainer="SHIFTECH AFRICA (support@shiftech.co.ke)"

# make sure apt is up to date
RUN apt-get update --fix-missing

# Install packages
RUN apt-get update && apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    redis \
    nginx \
    wget \
    build-essential \
    libssl-dev \
    zlib1g-dev \
    supervisor \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libjpeg62-turbo-dev \
    libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    libfreetype6 \
    g++

RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd

# Common PHP Extensions
RUN docker-php-ext-install \
    bz2 \
    pcntl \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    pdo_pgsql

#RUN apk add --no-cache nginx wget
# Install Redis
RUN pecl install redis && docker-php-ext-enable redis

RUN mkdir -p /run/nginx
RUN mkdir -p /etc/supervisor/logs

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/worker.conf

# Give us an easy way to modify php.ini without crazy hacks
ADD docker/custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini

RUN mkdir -p /app
COPY . /app
COPY .env.example /app/.env

RUN sh -c "wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"
RUN cd /app && \
    /usr/local/bin/composer install --no-dev

# Add user for laravel application
RUN groupadd -g 1000 laravel
RUN useradd -u 1000 -ms /bin/bash -g laravel laravel

RUN sudo chown -R laravel:www-data /app/storage \
    && sudo chown -R laravel:www-data /app/bootstrap/cache \
    && chmod -R 775 /app/storage \
    && chmod -R 775 /app/bootstrap/cache

RUN ["chmod", "+x", "/app/docker/startup.sh"]

#CMD ["sh","/app/docker/startup.sh"]
CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/conf.d/worker.conf"]

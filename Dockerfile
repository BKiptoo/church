FROM php:8.2-fpm

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
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
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
COPY docker/supervisord.conf /etc/supervisor/supervisord.conf

RUN mkdir -p /app
COPY . /app
COPY .env.example /app/.env

RUN sh -c "wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"
RUN cd /app && \
    /usr/local/bin/composer install --no-dev

RUN chown -R www-data:www-data /app \
    && chmod -R 775 /app/storage \
    && chmod -R 775 /app/bootstrap/cache

CMD sh /app/docker/startup.sh
#CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]

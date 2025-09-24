FROM php:8.4-fpm AS php

ENV PHP_OPCACHE_ENABLE=1 \
    PHP_OPCACHE_ENABLE_CLI=0 \
    PHP_OPCACHE_VALIDATE_TIMESTAMPS=1 \
    PHP_OPCACHE_REVALIDATE_FREQ=2

RUN apt-get update && apt-get install -y --no-install-recommends \
    unzip \
    libpq-dev \
    libcurl4-gnutls-dev \
    nginx \
    libonig-dev \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    iputils-ping \
    supervisor \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure gd --enable-gd --with-jpeg \
    && docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install pdo pdo_mysql bcmath curl mbstring opcache exif gd zip pcntl \
    && pecl install redis xdebug \
    && docker-php-ext-enable redis xdebug \
    && usermod --uid 1000 www-data \
    && groupmod --gid 1000 www-data

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./documentation/be-docker/configuration-files/php/php.ini /usr/local/etc/php/php.ini
COPY ./documentation/be-docker/configuration-files/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./documentation/be-docker/configuration-files/nginx/nginx.conf /etc/nginx/nginx.conf

WORKDIR /var/www

COPY --chown=www-data:www-data . .

ENTRYPOINT ["documentation/be-docker/configuration-files/entrypoint.sh"]

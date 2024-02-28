FROM php:8.2-fpm-alpine as php

RUN mkdir -p /var/www/news-admin-panel
WORKDIR /var/www/news-admin-panel

COPY php/opcache.ini /usr/local/etc/php/conf.d/
COPY php/custom.ini /usr/local/etc/php/conf.d/
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apk add --no-cache \
    icu-dev \
    linux-headers \
    libsodium \
    libsodium-dev \
    zip \
    libzip-dev \
    libpq-dev

RUN apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS; \
    pecl install amqp \
    && docker-php-ext-enable amqp; \
    apk del --no-network .phpize-deps

RUN docker-php-ext-configure zip\
    && docker-php-ext-install pdo pdo_pgsql pgsql exif sodium

RUN docker-php-ext-configure intl \
    && docker-php-ext-install \
        intl \
    && docker-php-ext-enable intl

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]

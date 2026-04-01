FROM php:8.5-fpm-alpine AS base

RUN apk add --no-cache \
    libpng-dev \
    libpq-dev \
    libzip-dev \
    icu-dev \
    jpeg-dev \
    freetype-dev \
    oniguruma-dev \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        linux-headers \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        mbstring \
        bcmath \
        gd \
        intl \
        zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps \
    && rm -rf /tmp/pear

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

FROM base AS dev

RUN apk add --no-cache git

COPY . .

RUN composer install

EXPOSE 9000

FROM base AS build

RUN apk add --no-cache git unzip

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

COPY . .

RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

FROM php:8.5-fpm-alpine AS prod

ARG WWWGROUP

RUN apk add --no-cache \
    libpng \
    libpq \
    libzip \
    icu \
    jpeg \
    freetype \
    oniguruma

COPY --from=base /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=base /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

RUN addgroup -g ${WWWGROUP:-1000} sail \
    && adduser -D -G sail -u 1000 sail

WORKDIR /var/www/html

COPY --from=build /app /var/www/html

RUN chown -R sail:sail /var/www/html \
    && chmod -R 775 storage bootstrap/cache

USER sail

EXPOSE 9000

FROM php:8.1-fpm-alpine
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/install-php-extensions
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN install-php-extensions \
    ctype \
    imagick \
    intl \
    pdo_mysql \
    xdebug

COPY docker/dev/php-fpm/php.ini /usr/local/etc/php/php.ini

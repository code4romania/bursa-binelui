FROM php:8.1-fpm-alpine as vendor

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/install-php-extensions
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN install-php-extensions \
    ctype \
    imagick \
    intl \
    pdo_mysql

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
ENV COMPOSER_CACHE_DIR /dev/null

WORKDIR /var/www

COPY --chown=www-data:www-data . /var/www

RUN composer install \
    --no-interaction \
    --no-scripts \
    --no-dev \
    --prefer-dist


FROM node:14-alpine as admin-assets

COPY composer.json /build/composer.json
COPY assets/admin /build/assets/admin
COPY --from=vendor /var/www/vendor /build/vendor

WORKDIR /build/assets/admin

RUN npm install
RUN npm run build

FROM node:18-alpine as website-assets

WORKDIR /build

ARG WEBSITE_ASSETS_OUTPUT_PATH="/build/output"

COPY assets/website /build/assets/website
COPY templates /build/templates

WORKDIR /build/assets/website

RUN npm ci --no-audit --ignore-scripts
RUN npm run build


FROM vendor

ARG S6_OVERLAY_VERSION=3.1.4.1

ADD https://github.com/just-containers/s6-overlay/releases/download/v${S6_OVERLAY_VERSION}/s6-overlay-noarch.tar.xz /tmp
RUN tar -C / -Jxpf /tmp/s6-overlay-noarch.tar.xz
ADD https://github.com/just-containers/s6-overlay/releases/download/v${S6_OVERLAY_VERSION}/s6-overlay-x86_64.tar.xz /tmp
RUN tar -C / -Jxpf /tmp/s6-overlay-x86_64.tar.xz

ENTRYPOINT ["/init"]

COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY docker/s6-rc.d /etc/s6-overlay/s6-rc.d

RUN apk update && \
    # production dependencies
    apk add --no-cache \
    nginx

COPY --from=admin-assets /build/public/build/admin /var/www/public/build/admin
COPY --from=website-assets /build/output /var/www/public/build/website

ENV APP_ENV prod
ENV APP_DEBUG false

ENV S6_CMD_WAIT_FOR_SERVICES_MAXTIME 0

EXPOSE 80

FROM php:8.2-fpm-alpine3.17 as base

ARG UID=1000
ARG GID=1000

WORKDIR /srv

COPY . .

RUN curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions -o - | sh -s \
      pdo_pgsql pgsql
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

FROM base as local
COPY ${PWD}/.docker/env/local/php.ini $PHP_INI_DIR/php.ini
COPY ${PWD}/.docker/env/local/nginx.conf /etc/nginx/nginx.conf
RUN apk add git nano
RUN adduser -u ${UID} -s /bin/sh -D user
USER user
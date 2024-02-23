FROM php:8.3-fpm

RUN apt update && apt install -y unzip && pecl install xdebug && docker-php-ext-enable xdebug

RUN addgroup --gid 1000 tech && adduser --uid 1000 --ingroup tech -shell /bin/bash --disabled-password tech

COPY ./backend-php-cli/conf.d /usr/local/etc/php/conf.d

RUN apt -y update \
    && apt install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql \
    && apt clean

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

WORKDIR /lexusalex-tech

USER tech

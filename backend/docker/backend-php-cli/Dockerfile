FROM php:8.3-cli

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

RUN addgroup --gid 1000 tech && adduser --uid 1000 --ingroup tech -shell /bin/bash --disabled-password tech

RUN apt update && apt install -y unzip && pecl install xdebug && docker-php-ext-enable xdebug

COPY ./backend-php-cli/conf.d /usr/local/etc/php/conf.d

RUN apt -y update \
    && apt install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql \
    && apt clean

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /lexusalex-tech/backend

USER tech

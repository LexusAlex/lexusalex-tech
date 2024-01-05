FROM php:8.3-fpm

RUN apt update && apt install -y unzip && pecl install xdebug && docker-php-ext-enable xdebug

COPY ./backend-php-cli/conf.d /usr/local/etc/php/conf.d

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

WORKDIR /lexusalex-tech

FROM php:8.2-fpm-alpine as poc-php

COPY php.ini "/usr/local/etc/php/conf.d/application.ini"

RUN apk add libzip-dev linux-headers && \
    docker-php-ext-install -j$(nproc) zip opcache pcntl pdo pdo_mysql sockets

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions openswoole

COPY . /srv/app
WORKDIR /srv/app

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install

ENTRYPOINT ["php", "public/workerman.php", "start"]

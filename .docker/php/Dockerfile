FROM mtk3d/php:8.0-fpm-nginx

COPY .docker/php/opcache.ini $PHP_INI_DIR/conf.d/opcache.ini

RUN apk update --no-cache && apk add icu-dev --no-cache && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl bcmath

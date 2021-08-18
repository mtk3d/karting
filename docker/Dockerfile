FROM mtk3d/php:8.0-fpm-nginx

RUN apk add icu-dev && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl bcmath

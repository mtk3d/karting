FROM php:8.0-fpm-alpine
WORKDIR /app

RUN apk upgrade --no-cache && \
    apk add --no-cache icu-dev gmp gmp-dev imagemagick nginx && \
    docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-configure intl && \
    docker-php-ext-install gmp pdo pdo_mysql opcache bcmath intl

COPY .docker/php/php.ini $PHP_INI_DIR/php.ini
COPY .docker/php/nginx.conf /etc/nginx/nginx.conf
COPY .docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/zzz-php-fpm.conf

CMD ["sh", "-c", "php-fpm --daemonize && nginx"]

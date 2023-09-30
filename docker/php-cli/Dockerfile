FROM php:7.2-cli

RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis


RUN apt-get update && apt-get install -y libpq-dev unzip \
    libmcrypt-dev mariadb-client \
        && docker-php-ext-install pdo_mysql pdo_pgsql pcntl

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY zz-php.ini /usr/local/etc/php/conf.d/zz-php.ini

RUN apt-get update \
    && apt-get install -y libmcrypt-dev \
    && rm -rf /var/lib/apt/lists/* \
    && pecl install mcrypt-1.0.1 \
    && docker-php-ext-enable mcrypt

RUN php -d memory_limit=256M

WORKDIR /var/www
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_MEMORY_LIMIT -1


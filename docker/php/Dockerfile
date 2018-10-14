FROM php:7.2-fpm

RUN apt-get update && apt-get install -y git zlib1g-dev unzip nano procps && \
    docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /var/.composer

RUN mkdir -p /var/www /var/.composer
WORKDIR /var/www

COPY . /var/www

RUN groupadd php_container && useradd -r -u 1000 -g php_container php_container && \
    chown -R php_container /var/www /var/.composer
USER php_container

RUN APP_ENV=prod composer install --no-dev --optimize-autoloader

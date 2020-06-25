FROM php:7.4-apache

RUN apt-get update -y && apt-get install -y git zip unzip

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY . /var/www/html

RUN cd /var/www/html
RUN /usr/bin/composer install --prefer-dist
FROM php:7.3-apache

RUN a2enmod rewrite
RUN service apache2 restart

WORKDIR /var/www

RUN rm -rf ./html

COPY . .
COPY ./public ./html

VOLUME ./sp_conf

RUN apt update -y && apt install -y git zip libpq-dev
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pgsql pdo_pgsql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --no-interaction

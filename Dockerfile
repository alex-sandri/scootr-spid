FROM php:7.3-apache

RUN a2enmod rewrite
RUN service apache2 restart

WORKDIR /app

COPY /idp_metadata /idp_metadata
COPY /sp_conf /sp_conf
COPY /src .
COPY /composer.json .
COPY /composer.lock .

VOLUME /app/sp_conf

RUN rm -rf /var/www/html && ln -s /app /var/www/html
RUN apt update -y && apt install -y git zip libpq-dev
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pgsql pdo_pgsql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --no-interaction

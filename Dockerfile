FROM php:7.2-apache
RUN a2enmod rewrite
RUN service apache2 restart
WORKDIR /app
COPY . /app
VOLUME /app/sp_conf
RUN rm -rf /var/www/html && ln -s /app /var/www/html
RUN apt update -y && apt install -y git zip libpq-dev
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pgsql pdo_pgsql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --no-interaction

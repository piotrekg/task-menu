FROM php:7.4-fpm

RUN apt update && apt install -y git zip && \
    docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /app

# Composer
RUN curl -s https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer global require hirak/prestissimo

# App
COPY . .
RUN composer install

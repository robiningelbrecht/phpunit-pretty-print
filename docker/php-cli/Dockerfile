FROM php:8.4-cli

RUN apt-get update && apt-get install -y zip unzip git curl
RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
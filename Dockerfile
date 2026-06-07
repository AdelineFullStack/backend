FROM php:8.2-fpm-alpine

# Installation des extensions pour MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Installation de l'extension pour MongoDB (nécessite de compiler)
RUN apk add --no-cache $PHPIZE_DEPS openssl-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

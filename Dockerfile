FROM php:8.4.7-apache

RUN apt-get update && apt-get install -y \
    default-mysql-client \
    && docker-php-ext-install mysqli

RUN a2enmod rewrite

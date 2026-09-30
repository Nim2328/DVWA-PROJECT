FROM php:8-apache

WORKDIR /var/www/html

# Update Debian repositories to HTTPS
RUN sed -i "s|http://deb.debian.org|https://deb.debian.org|g" /etc/apt/sources.list.d/debian.sources

# Install required packages and PHP extensions
RUN apt-get update \
    && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y \
        zlib1g-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        iputils-ping \
        git \
        zip \
        unzip \
        7zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && a2enmod rewrite \
    && docker-php-ext-install gd mysqli pdo pdo_mysql

# Copy Composer from the official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copy DVWA project files
COPY --chown=www-data:www-data . .

# Create DVWA configuration from the template
COPY --chown=www-data:www-data \
    config/config.inc.php.dist \
    config/config.inc.php

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose Apache
EXPOSE 80

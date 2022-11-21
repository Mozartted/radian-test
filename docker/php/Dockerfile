FROM php:7.3-fpm

RUN apt-get update && \
    apt-get install -y libpng-dev libjpeg-dev libpq-dev zip unzip sudo wget zlib1g-dev libicu-dev libzstd-dev libzip-dev librdkafka-dev g++ && \
    rm -rf /var/lib/apt/lists/*

RUN yes | pecl install igbinary redis grpc protobuf xdebug-2.9.3 rdkafka-3.1.3

RUN docker-php-ext-install intl && \
    docker-php-ext-install gd && \
    docker-php-ext-install mbstring && \
    docker-php-ext-install opcache && \
    docker-php-ext-install zip && \
    docker-php-ext-install calendar && \
    docker-php-ext-install sockets && \
    docker-php-ext-enable igbinary && \
    docker-php-ext-enable redis && \
    docker-php-ext-enable grpc && \
    docker-php-ext-enable protobuf && \
    docker-php-ext-enable xdebug && \
    docker-php-ext-enable rdkafka

## Install composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

# Register the COMPOSER_HOME environment variable
ENV COMPOSER_HOME /composer

# Add global binary directory to PATH and make sure to re-export it
ENV PATH /composer/vendor/bin:$PATH

# Allow Composer to be run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# # Setup the Composer installer
# RUN curl -o /tmp/composer-setup.php https://getcomposer.org/installer \
#   && curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig \
#   && php -r "if (hash('SHA384', file_get_contents('/tmp/composer-setup.php')) !== trim(file_get_contents('/tmp/composer-setup.sig'))) { unlink('/tmp/composer-setup.php'); echo 'Invalid installer' . PHP_EOL; exit(1); }" \
#   && php /tmp/composer-setup.php --no-ansi --install-dir=/usr/local/bin --filename=composer \
#   && rm -rf /tmp/composer-setup.php

# Set up the working directory
WORKDIR /var/www/app
ARG DOCKER_PHP_VERSION

FROM php:${DOCKER_PHP_VERSION}-fpm

RUN apt-get update \
  && apt-get install -y --no-install-recommends \
    curl \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev \
  && rm -rf /var/lib/apt/lists/*

  RUN docker-php-ext-install pdo_mysql \
  && docker-php-ext-install pdo_pgsql \
  && docker-php-ext-install gd

ARG DOCKER_PHP_VERSION

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update -yqq && \
    apt-get install -y apt-utils && \
    pecl channel-update pecl.php.net

###########################################################################

RUN apt-get install libzip-dev -y && \
    docker-php-ext-configure zip --with-libzip && \
    docker-php-ext-install exif;

RUN docker-php-ext-install opcache;
COPY ./opcache.ini /usr/local/etc/php/conf.d/opcache.ini

###########################################################################

RUN pecl install mongodb && \
    docker-php-ext-enable mongodb

RUN echo "extension=mongodb.so" > /usr/local/etc/php/php.ini

###########################################################################

USER root
RUN apt-get install libyaml-dev -y ; \
    pecl install yaml ; \
    docker-php-ext-enable yaml;

###########################################################################

USER root

RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

RUN usermod -u 1000 www-data

USER www-data

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000

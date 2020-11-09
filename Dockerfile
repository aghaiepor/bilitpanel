# development use this image
# FROM php:7.4-fpm

# production use this image
FROM dr.atishahr.net:8090/php_7_4_fpm

COPY ./sibpanel_v2/composer.lock ./sibpanel_v2/composer.json ./sibpanel_v2/package.json /usr/src/app/

ENV DOCKERIZE_VERSION 0.6.1

COPY ./dockerize-alpine-linux-amd64-v0.6.1.tar.gz /tmp

# Install dockerize so we can wait for containers to be ready
RUN tar -C /usr/local/bin -xzvf /tmp/dockerize-alpine-linux-amd64-v0.6.1.tar.gz

# Install nodejs
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash


# Install system dependencies
RUN apt-get update && DEBIAN_FRONTEND=noninteractive 
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        vim \
        libmemcached-dev \
        libz-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        libfreetype6-dev \
        libssl-dev \
        libmcrypt-dev \
        libzip-dev \
        unzip \
        zip \
        sed \
        nodejs \
    && docker-php-ext-configure gd \
    && docker-php-ext-configure zip \
    && docker-php-ext-install \
        gd \
        exif \
        opcache \
        pdo_mysql \
        pdo_pgsql \
        pcntl \
        zip \
    && rm -rf /var/lib/apt/lists/*;

# Set timezone
ENV TZ=Asia/Tehran
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY ./laravel.ini /usr/local/etc/php/conf.d/laravel.ini

# RUN chown -R www-data:www-data /var/www/

# Nginx settings
#COPY timeout.conf /etc/nginx/conf.d/
#COPY nginx.conf /etc/nginx/sites-available/default
#RUN ln -sf /dev/stdout /var/log/nginx/access.log \
# && ln -sf /dev/stderr /var/log/nginx/error.log

# Create system user to run Composer and Artisan Commands
#RUN useradd -G www-data,root -u $uid -d /home/$user $user
#RUN mkdir -p /home/$user/.composer && \
#chown -R $user:$user /home/$user

# Set working directory
#WORKDIR /var/www
#ARG PROJECT=sibpanel_v2
#COPY --chown=www-data:www-data sibpanel_v2 /var/www/${PROJECT}
#EXPOSE 80
#USER $user
#COPY start_server.sh /var/www/
#RUN ls -lh
#CMD ["/usr/bin/bash", "/var/www/start_server.sh"]


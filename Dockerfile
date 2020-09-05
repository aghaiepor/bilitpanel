FROM ubuntu:20.04

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && DEBIAN_FRONTEND=noninteractive && apt-get upgrade -y && apt-get autoremove && apt-get autoclean
RUN DEBIAN_FRONTEND=noninteractive apt-get install -y \
    libffi-dev \
    libssl-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    net-tools \
    vim \
    nginx \
    php7.4 \
    php7.4-fpm \
    git \
    curl \
    zip \
    unzip 

# Set timezone
ENV TZ=Asia/Tehran
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone


# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Nginx settings
COPY timeout.conf /etc/nginx/conf.d/
#RUN ln -sf /dev/stdout /var/log/nginx/access.log \
# && ln -sf /dev/stderr /var/log/nginx/error.log

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www
ARG PROJECT=sibpanel_v2
COPY --chown=www-data:www-data sibpanel_v2 /var/www/${PROJECT}
EXPOSE 80
#USER $user
COPY start_server.sh /var/www/
RUN ls -lh
CMD ["/usr/bin/env bash", "/var/www/start_server.sh"]


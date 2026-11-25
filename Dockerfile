FROM ubuntu:24.04

ENV DEBIAN_FRONTEND=noninteractive
ARG APT_MIRROR=http://archive.ubuntu.com/ubuntu

RUN test -n "$APT_MIRROR" && \
    printf 'deb %s noble main restricted universe multiverse\n' "$APT_MIRROR" > /etc/apt/sources.list && \
    printf 'deb %s noble-updates main restricted universe multiverse\n' "$APT_MIRROR" >> /etc/apt/sources.list && \
    printf 'deb %s noble-security main restricted universe multiverse\n' "$APT_MIRROR" >> /etc/apt/sources.list && \
    printf 'Acquire::Retries "5";\nAcquire::http::Pipeline-Depth "0";\nAcquire::CompressionTypes::Order "gz";\n' > /etc/apt/apt.conf.d/99-repository && \
    apt-get clean && \
    apt-get update -o Acquire::CompressionTypes::Order=gz && apt-get install -y --no-install-recommends \
    ca-certificates composer curl unzip git nginx supervisor \
    php8.3 php8.3-cli php8.3-fpm php8.3-mysql php8.3-sqlite3 php8.3-mbstring \
    php8.3-xml php8.3-curl php8.3-zip php8.3-gd php8.3-bcmath php8.3-intl \
    php8.3-redis && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/
COPY sibpanel_v2/composer.json ./
RUN composer update --no-interaction --no-progress --prefer-dist --optimize-autoloader --no-scripts
COPY sibpanel_v2/ ./
RUN composer dump-autoload --no-interaction --optimize
COPY laravel.ini /etc/php/8.3/fpm/conf.d/99-laravel.ini
COPY nginx.conf /etc/nginx/nginx.conf
COPY default.conf /etc/nginx/conf.d/default.conf
COPY entrypoint.sh /opt/entrypoint.sh
RUN chmod +x /opt/entrypoint.sh && rm -f /etc/nginx/sites-enabled/default

EXPOSE 80
EXPOSE 443
ENTRYPOINT ["bash", "/opt/entrypoint.sh"]

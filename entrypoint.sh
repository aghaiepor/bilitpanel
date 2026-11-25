#!/bin/bash
set -e

cd /var/www
[ -f .env ] || (cp /opt/larav_env .env 2>/dev/null || cp .env.example .env)

if [ ! -f composer.json ]; then
    echo "ERROR: /var/www/composer.json not found" >&2
    exit 1
fi

if [ ! -f vendor/autoload.php ]; then
    echo "ERROR: /var/www/vendor/autoload.php is missing from the image" >&2
    exit 1
fi

if ! grep -q '^APP_KEY=base64:' .env; then
    php artisan key:generate --force
fi
chown -R www-data:www-data storage bootstrap/cache

service php8.3-fpm start
nginx -t
exec nginx -g "daemon off;"

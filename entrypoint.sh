#!/bin/bash
composer install
cp /opt/db.sqlite /var/www/database/
cp /opt/larav_env /var/www/.env
chown -R www-data:www-data database storage public
service php7.4-fpm start
nginx -g "daemon off;"
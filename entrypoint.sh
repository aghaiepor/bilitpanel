#!/bin/bash
composer install
chown -R www-data:www-data database storage
service php7.4-fpm start
service --status-all
nginx -g "daemon off;"
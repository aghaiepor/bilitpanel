#!/bin/bash

envsubst '$NGINX_ROOT $NGINX_FPM_HOST $NGINX_FPM_PORT' < /etc/nginx/fpm.tmpl > /etc/nginx/conf.d/default.conf
chown -R www-data:www-data /var/www/
exec nginx -g "daemon off;"

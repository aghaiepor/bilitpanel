#!/usr/bin/env bash 
# start-server.sh 
echo `pwd`
# run lavavel project with www-data user
# cd /var/www/sibpanel_v2
exec nginx -g "daemon off;"

# envsubst '$NGINX_ROOT $NGINX_FPM_HOST $NGINX_FPM_PORT' < /etc/nginx/fpm.tmpl > /etc/nginx/conf.d/default.conf
# exec nginx -g "daemon off;
# https://engineering.carsguide.com.au/how-to-dockerize-a-laravel-application-77a24ba669c5

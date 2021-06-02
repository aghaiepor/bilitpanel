FROM dr.atishahr.net:8090/sibpanel:v2
WORKDIR /var/www/
# copy and run
COPY /tourism/municipality/laravel.ini /usr/local/etc/php/conf.d/laravel.ini
COPY /tourism/municipality/sibpanel_v2 /var/www/
COPY /tourism/municipality/nginx.conf /etc/nginx/nginx.conf
COPY ./default.conf /etc/nginx/conf.d/
COPY /tourism/municipality/entrypoint.sh /tourism/municipality/db.sqlite ./larav_env /opt/
EXPOSE 80
EXPOSE 443
ENTRYPOINT ["bash", "/opt/entrypoint.sh"]
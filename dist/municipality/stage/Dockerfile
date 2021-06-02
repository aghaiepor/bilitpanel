FROM dr.atishahr.net:8090/sibpanel:v2
WORKDIR /var/www/
# copy and run
COPY /front/municipality/laravel.ini /usr/local/etc/php/conf.d/laravel.ini
COPY /front/municipality/sibpanel_v2 /var/www/
COPY /front/municipality/nginx.conf /etc/nginx/nginx.conf
COPY ./default.conf /etc/nginx/conf.d/
COPY /front/municipality/entrypoint.sh /front/municipality/db.sqlite ./larav_env /opt/
EXPOSE 80
EXPOSE 443
ENTRYPOINT ["bash", "/opt/entrypoint.sh"]
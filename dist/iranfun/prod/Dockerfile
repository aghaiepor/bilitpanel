FROM dr.atishahr.net:8090/sibpanel:v2
WORKDIR /var/www/
# copy and run
COPY /front/iranfun/laravel.ini /usr/local/etc/php/conf.d/laravel.ini
COPY /front/iranfun/sibpanel_v2 /var/www/
COPY /front/iranfun/nginx.conf /etc/nginx/nginx.conf
COPY ./default.conf /etc/nginx/conf.d/
COPY /front/iranfun/entrypoint.sh /front/iranfun/db.sqlite ./larav_env /opt/
EXPOSE 80
EXPOSE 443
ENTRYPOINT ["bash", "/opt/entrypoint.sh"]
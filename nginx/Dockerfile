# development use this image
# FROM nginx:latest
# production use this image
FROM dr.atishahr.net:8090/nginx_doc_reg:latest

ENV NGINX_ROOT /var/www/sibpanel_v2/public
ENV NGINX_FPM_HOST localhost
ENV NGINX_FPM_PORT 9000

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
COPY fpm-template.conf /etc/nginx/fpm.tmpl

RUN rm -f /etc/nginx/conf.d/default.conf
RUN rm -f /etc/nginx/nginx.conf

COPY nginx.conf /etc/nginx/nginx.conf
RUN sed -i "s|# Gzip Settings|server_tokens off;|g" /etc/nginx/nginx.conf
EXPOSE 80

ENTRYPOINT ["entrypoint.sh"]

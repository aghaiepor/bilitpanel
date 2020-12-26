
FROM dr.atishahr.net:8090/php_7_4_fpm

# Install system dependencies
RUN apt-get update
RUN apt-get install -y supervisor

# Set timezone
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# queue worker
COPY ./supervisord.conf /etc/supervisord.conf
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]

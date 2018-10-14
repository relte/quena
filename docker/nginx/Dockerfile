FROM nginx:1.13.9

RUN apt-get update && apt-get install -y procps

RUN mkdir -p /var/www

COPY . /var/www
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

RUN groupadd nginx_container && useradd -r -u 1000 -g nginx_container nginx_container && \
    touch /var/run/nginx.pid && chown -R nginx_container /var/www/public /var/cache/nginx /var/run/nginx.pid

USER nginx_container

WORKDIR /var/www

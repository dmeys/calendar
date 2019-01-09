FROM ubuntu:14.04

RUN apt-get update && apt-get install -y apt-transport-https && apt-get update && \
    apt-get install -y --force-yes curl apt-transport-https lsb-release ca-certificates && \
    sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg && \
    echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/php.list && \
    sudo apt-get update && \
    apt-get install -y php7.2-cli php7.2-curl php7.2-mysql php7.2-fpm php7.2-pgsql php7.2-memcached php7.2-memcache php7.2-zip php7.2-mbstring php7.2-dom

RUN cd /bin && curl -sS https://getcomposer.org/installer | php && mv composer.phar composer && \
    cd /var/www/backend && composer install

ADD nginx.conf /etc/nginx/sites-enabled/

ADD ../ /var/www/backend/

RUN echo "daemon off;" >> /etc/nginx/nginx.conf

EXPOSE 80

CMD service nginx start
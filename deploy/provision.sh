#!/bin/sh
sudo apt-get update
# HTTPS Transport.
sudo apt-get install -y apt-transport-https
sudo apt-get update
sudo apt-get install -y --force-yes postgresql postgresql-contrib memcached curl
sudo apt-get install apt-transport-https lsb-release ca-certificates
sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
sudo echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/php.list
sudo apt-get update
sudo apt-get install -y php7.2
sudo apt-get install -y libmcrypt-dev php7.2-cli php7.2-curl php7.2-mysql php7.2-fpm php7.2-pgsql php7.2-gd php7.2-memcached php7.2-memcache php7.2-zip php7.2-mbstring php7.2-dom php7.2-gd php7.2-dev php7.2-sqlite3 php-pear php7.2-intl
sudo pecl install --nodeps mcrypt-snapshot
sudo bash -c "echo extension=mcrypt.so > /etc/php/7.2/cli/conf.d/20-mcrypt.ini"
sudo bash -c "echo extension=mcrypt.so > /etc/php/7.2/fpm/conf.d/20-mcrypt.ini"
sudo service php7.2-fpm restart
# Remove apache & install nginx
sudo apt-get purge -y apache2
sudo apt-get install -y nginx

# Setup postgres
sudo -u postgres psql -c "CREATE USER root WITH PASSWORD '123oij1oi3jd1o2i3j';"
sudo -u postgres psql -c "CREATE DATABASE calendar;"
sudo -u postgres psql -c "grant all privileges on database calendar to root;"
sudo echo "listen_addresses = '*'" >> /etc/postgresql/9.4/main/postgresql.conf
sudo echo "host calendar root all md5" >> /etc/postgresql/9.4/main/pg_hba.conf
sudo service postgresql restart
# Create SWAP
/bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
/sbin/mkswap /var/swap.1
/sbin/swapon /var/swap.1
# Get Composer
cd /bin && curl -sS https://getcomposer.org/installer | sudo php && mv composer.phar composer
# Run laravel
#cd /var/www/backend && \
#    sudo -u vagrant composer install && \
#    sudo php artisan key:generate && \
#    sudo php artisan config:cache
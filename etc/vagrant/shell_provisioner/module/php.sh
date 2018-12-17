#!/bin/bash

# PHP

apt install -y apt-transport-https lsb-release ca-certificates
wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
echo "deb https://packages.sury.org/php/ jessie main" > /etc/apt/sources.list.d/php.list
sudo apt update

apt-get -y install php7.2-cli php7.2-fpm php7.2-dev php7.2-curl php7.2-intl \
    php7.2-mysql php7.2-sqlite3 php7.2-gd php7.2-mbstring php7.2-xml php7.2-zip php7.2-xdebug

sed -i 's/;date.timezone.*/date.timezone = Europe\/Paris/' /etc/php/7.2/fpm/php.ini
sed -i 's/;date.timezone.*/date.timezone = Europe\/Paris/' /etc/php/7.2/cli/php.ini
sed -i 's/^user = www-data/user = vagrant/' /etc/php/7.2/fpm/pool.d/www.conf
sed -i 's/^group = www-data/group = vagrant/' /etc/php/7.2/fpm/pool.d/www.conf

# xdebug
cp ${CONFIG_PATH}/php/xdebug.ini /etc/php/7.2/mods-available/xdebug.ini

service php7.2-fpm restart

# composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin
ln -s /usr/bin/composer.phar /usr/bin/composer
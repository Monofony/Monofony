#!/bin/bash

plog "Adding repo for php7.1"
apt install -y apt-transport-https lsb-release ca-certificates
wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
echo "deb https://packages.sury.org/php/ jessie main" > /etc/apt/sources.list.d/php.list
sudo apt update

plog "Instaling php7 and its dependencies"
apt-get -y install php7.1-cli php7.1-fpm php7.1-dev php7.1-curl php7.1-intl \
    php7.1-mysql php7.1-sqlite3 php7.1-gd php7.1-mbstring php7.1-xml php7.1-zip php7.1-xdebug

plog "Configuring www-data user and timezone"
sed -i 's/;date.timezone.*/date.timezone = Europe\/Paris/' /etc/php/7.1/fpm/php.ini
sed -i 's/;date.timezone.*/date.timezone = Europe\/Paris/' /etc/php/7.1/cli/php.ini
sed -i 's/^user = www-data/user = vagrant/' /etc/php/7.1/fpm/pool.d/www.conf
sed -i 's/^group = www-data/group = vagrant/' /etc/php/7.1/fpm/pool.d/www.conf

plog "Configuring Xdebug"
cp ${CONFIG_PATH}/php/xdebug.ini /etc/php/7.1/mods-available/xdebug.ini

plog "Restarting PHP7 service"
service php7.1-fpm restart

plog "Retrieving and installing composer in /usr/bin"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin
ln -s /usr/bin/composer.phar /usr/bin/composer

plog "Checking PHP is correctly installed with Xdebug"
! php --version | grep -q 'with Xdebug' && raiseError "PHP is not installed with Xdebug"

#!/bin/bash

plog "Instaling php7 and its dependencies"
apt-get -y install php7.0-cli php7.0-fpm php7.0-dev php7.0-curl php7.0-intl \
    php7.0-mysql php7.0-sqlite3 php7.0-gd php7.0-mbstring php7.0-xml php7.0-zip php7.0-xdebug

plog "Configuring www-data user and timezone"
sed -i 's/;date.timezone.*/date.timezone = Europe\/Paris/' /etc/php/7.0/fpm/php.ini
sed -i 's/;date.timezone.*/date.timezone = Europe\/Paris/' /etc/php/7.0/cli/php.ini
sed -i 's/^user = www-data/user = vagrant/' /etc/php/7.0/fpm/pool.d/www.conf
sed -i 's/^group = www-data/group = vagrant/' /etc/php/7.0/fpm/pool.d/www.conf

plog "Configuring Xdebug"
cp ${CONFIG_PATH}/php/xdebug.ini /etc/php/7.0/mods-available/xdebug.ini

plog "Restarting PHP7 service"
service php7.0-fpm restart

plog "Retrieving and installing composer in /usr/bin"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin
ln -s /usr/bin/composer.phar /usr/bin/composer

plog "Checking PHP is correctly installed with Xdebug"
! php --version | grep -q 'with Xdebug' && raiseError "PHP is not installed with Xdebug"

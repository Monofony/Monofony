#!/usr/bin/env bash

# Set php version through phpenv.
phpenv local 7.1

# Install dependencies through Composer
composer install --prefer-dist --no-interaction

# mysql
sed -i 's/database_host.*/database_host: 127.0.0.1/' app/config/parameters.yml
sed -i "s/database_user.*/database_user: ${MYSQL_USER}/" app/config/parameters.yml
sed -i "s/database_password.*/database_password: ${MYSQL_PASSWORD}/" app/config/parameters.yml
sed -i "s/dbname.*/dbname: test/" app/config/config_test.yml

# php
sed -i'' 's/^memory_limit=.*/memory_limit = -1/g' ${HOME}/.phpenv/versions/$(phpenv version-name)/etc/php.ini

# database creation
php bin/console doctrine:migrations:migrate --env=test -n
php bin/console cache:clear --no-warmup --env=test
#!/bin/bash

source /vagrant/shell_provisioner/helpers/plog.sh

plog "Installing application app_name with composer"
composer install -vvv -d /var/www/app_name --optimize-autoloader

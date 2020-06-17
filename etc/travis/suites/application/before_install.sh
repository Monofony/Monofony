#!/usr/bin/env bash

source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/../../../bash/common.lib.sh"
source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/../../../bash/application.sh"

print_header "Activating memcached extension" "AppName"
run_command "echo \"extension = memcached.so\" >> ~/.phpenv/versions/$(phpenv version-name)/etc/conf.d/travis.ini" || exit $?

# Download and configure Symfony webserver
print_header "Downloading Symfony CLI" "Sylius"
if [ ! -f $APP_NAME_CACHE_DIR/symfony ]; then
    run_command "wget https://get.symfony.com/cli/installer -O - | bash"
    run_command "mv ~/.symfony/bin/symfony $APP_NAME_CACHE_DIR"
fi
run_command "$APP_NAME_CACHE_DIR/symfony version"

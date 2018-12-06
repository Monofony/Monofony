#!/usr/bin/env bash

source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/../../../bash/common.lib.sh"
source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/../../../bash/application.sh"

print_header "Setting xvfb up" "AppName"
run_command "export DISPLAY=:99.0"
run_command "sh -e /etc/init.d/xvfb start"
run_command "sleep 3"

print_header "Setting the application up" "AppName"
run_command "bin/console doctrine:database:create --env=test -vvv" || exit $? # Have to be run with debug = true, to omit generating proxies before setting up the database
run_command "bin/console cache:warmup --env=test --no-debug -vvv" || exit $?
run_command "bin/console doctrine:migrations:migrate --no-interaction --env=test --no-debug -vvv" || exit $?

print_header "Setting the web assets up" "AppName"
run_command "bin/console assets:install --env=test --no-debug -vvv" || exit $?

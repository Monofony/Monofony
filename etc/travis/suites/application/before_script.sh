#!/usr/bin/env bash

source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/../../../bash/common.lib.sh"
source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/../../../bash/application.sh"

print_header "Setting the application up" "AppName"
run_command "APP_DEBUG=1 bin/console doctrine:database:create -vvv" || exit $? # Have to be run with debug = true, to omit generating proxies before setting up the database
run_command "APP_DEBUG=1 APP_ENV=dev bin/console cache:warmup -vvv" || exit $? # For PHPStan
run_command "bin/console cache:warmup -vvv" || exit $? # For tests
run_command "bin/console doctrine:migrations:migrate --no-interaction -vvv" || exit $?

print_header "Setting the web assets up" "AppName"
run_command "bin/console assets:install public -vvv" || exit $?
run_command "yarn install && yarn run encore production" || exit $?

# Configure display
run_command "/sbin/start-stop-daemon --start --quiet --pidfile /tmp/xvfb_99.pid --make-pidfile --background --exec /usr/bin/Xvfb -- :99 -ac -screen 0 2880x1800x16"
run_command "export DISPLAY=:99"

# Download and configure ChromeDriver
if [ ! -f $APP_NAME_CACHE_DIR/chromedriver ] || [ "$($APP_NAME_CACHE_DIR/chromedriver --version | grep -c 2.34)" = "0" ]; then
    run_command "curl http://chromedriver.storage.googleapis.com/2.34/chromedriver_linux64.zip > chromedriver.zip"
    run_command "unzip chromedriver.zip"
    run_command "chmod +x chromedriver"
    run_command "mv chromedriver $APP_NAME_CACHE_DIR"
fi

# Run ChromeDriver
run_command "$APP_NAME_CACHE_DIR/chromedriver > /dev/null 2>&1 &"

# Download and configure Selenium
if [ ! -f $APP_NAME_CACHE_DIR/selenium.jar ] || [ "$(java -jar $APP_NAME_CACHE_DIR/selenium.jar --version | grep -c 3.4.0)" = "0" ]; then
    run_command "curl http://selenium-release.storage.googleapis.com/3.4/selenium-server-standalone-3.4.0.jar > selenium.jar"
    run_command "mv selenium.jar $APP_NAME_CACHE_DIR"
fi

# Run Selenium
run_command "java -Dwebdriver.chrome.driver=$APP_NAME_CACHE_DIR/chromedriver -jar $APP_NAME_CACHE_DIR/selenium.jar > /dev/null 2>&1 &"

# Run webserver
run_command "$APP_NAME_CACHE_DIR/symfony server:ca:install"
run_command "$APP_NAME_CACHE_DIR/symfony server:start --port=8080 --dir=public --force-php-discovery --daemon"

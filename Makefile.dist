TAGS?=~todo

build-docs:
	cd docs && sphinx-build -b html . build -a

install:
	composer install --no-interaction
	bin/console app:install -n
	bin/console sylius:fixtures:load -n
	yarn install && yarn build

load-fixtures:
	bin/console sylius:fixtures:load default --no-interaction

test-behat:
	APP_ENV=test vendor/bin/behat --tags=${TAGS} ${ARGS}

test-behat-without-javascript:
	APP_ENV=test vendor/bin/behat --tags=~javascript --tags=${TAGS}

test-behat-with-cli:
	APP_ENV=test vendor/bin/behat --tags=cli --tags=${TAGS}

test-infection:
	phpdbg -qrr vendor/bin/infection ${ARGS}

test-phpspec:
	phpdbg -qrr vendor/bin/phpspec run -n ${ARGS}

test-phpstan::
	APP_ENV=dev bin/console cache:clear
	APP_ENV=dev bin/console cache:warmup
	vendor/bin/phpstan analyse -c phpstan.neon -l 1 src

test-phpunit:
	APP_ENV=test vendor/bin/phpunit ${ARGS}

start:
	bin/console server:start ${ARGS}

stop:
	bin/console server:stop

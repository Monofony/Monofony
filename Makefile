test: validate test-phpspec analyse test-phpunit test-installer test-fixtures test-behat test-doctrine-migrations

analyse: test-phpstan test-psalm

validate: validate-composer validate-composer-security validate-doctrine-schema validate-twig validate-yaml-files validate-yarn-packages

test-behat: test-behat-without-javascript test-behat-with-javascript test-behat-with-cli

validate-composer:
	composer validate --strict

validate-composer-security:
	vendor/bin/security-checker security:check

validate-doctrine-schema:
	bin/console doctrine:schema:validate -vvv

validate-twig:
	bin/console lint:twig templates

validate-yaml-files:
	bin/console lint:yaml config --parse-tags

validate-yarn-packages:
	yarn check

test-phpspec:
	phpdbg -qrr vendor/bin/phpspec run --no-interaction -f dot

test-phpstan:
	vendor/bin/phpstan analyse -c phpstan.neon -l 1 src

test-psalm:
	vendor/bin/psalm --show-info=false

test-phpunit:
	vendor/bin/phpunit

test-installer:
	bin/console app:install --no-interaction -vvv

test-fixtures:
	bin/console sylius:fixtures:load default --no-interaction

test-behat-without-javascript:
	vendor/bin/behat --strict --no-interaction -vvv -f progress --tags="~@javascript && ~@todo && ~@cli"

test-behat-with-javascript:
	vendor/bin/behat --strict --no-interaction -vvv -f progress --tags="@javascript && ~@todo && ~@cli"

test-behat-with-cli:
	vendor/bin/behat --strict --no-interaction -vvv -f progress --tags="@cli && ~@todo"

test-doctrine-migrations:
	bin/console doctrine:migrations:migrate first --no-interaction
	bin/console doctrine:migrations:migrate latest --no-interaction

test-prod-requirements:
	composer install --no-dev --no-interaction --prefer-dist
	APP_ENV=prod bin/console cache:clear
	composer install --no-interaction --prefer-dist

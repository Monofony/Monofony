test: validate test-phpspec analyse test-phpunit test-installer test-fixtures test-behat test-doctrine-migrations
.PHONY: test

analyse: test-phpstan test-psalm
.PHONY: analyse

validate: validate-composer validate-composer-security validate-doctrine-schema validate-twig validate-yaml-files validate-yarn-packages
.PHONY: validate

test-behat: test-behat-without-javascript test-behat-with-javascript test-behat-with-cli
.PHONY: test-behat

validate-composer:
	composer validate --strict
.PHONY: validate-composer

validate-composer-security:
	vendor/bin/security-checker security:check
.PHONY: validate-composer-security

validate-doctrine-schema:
	bin/console doctrine:schema:validate -vvv
.PHONY: validate-doctrine-schema

validate-twig:
	bin/console lint:twig templates
.PHONY: validate-twig

validate-yaml-files:
	bin/console lint:yaml config --parse-tags
.PHONY: validate-yaml-files

validate-yarn-packages:
	yarn check
.PHONY: validate-yarn-packages

test-phpspec:
	phpdbg -qrr vendor/bin/phpspec run --no-interaction -f dot
.PHONY: test-phpspec

test-phpstan:
	vendor/bin/phpstan analyse -c phpstan.neon -l 1 src
.PHONY: test-phpstan

test-psalm:
	vendor/bin/psalm --show-info=false
.PHONY: test-psalm

test-phpunit:
	vendor/bin/phpunit
.PHONY: test-phpunit

test-installer:
	bin/console app:install --no-interaction -vvv
.PHONY: test-installer

test-behat-with-cli:
	vendor/bin/behat --strict --no-interaction -vvv -f progress --tags="@cli && ~@todo"
.PHONY: test-behat-with-cli

test-doctrine-migrations:
	bin/console doctrine:migrations:migrate first --no-interaction
	bin/console doctrine:migrations:migrate latest --no-interaction
.PHONY: test-doctrine-migrations

test-prod-requirements:
	composer dump-env prod
	composer install --no-dev --no-interaction --prefer-dist --no-scripts
.PHONY: test-prod-requirements

test-behat-without-javascript:
	vendor/bin/behat --strict --no-interaction -vvv -f progress --tags="~@javascript && ~@todo && ~@cli"
.PHONY: test-behat-without-javascript

test-behat-with-javascript:
	vendor/bin/behat --strict --no-interaction -vvv -f progress --tags="@javascript && ~@todo && ~@cli"
.PHONY: test-behat-with-javascript

test-fixtures:
	bin/console sylius:fixtures:load default --no-interaction
.PHONY: test-fixtures

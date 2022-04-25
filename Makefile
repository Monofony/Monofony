test: validate test-phpspec analyse test-phpunit test-installer test-fixtures test-behat test-doctrine-migrations
.PHONY: test

analyse: test-phpstan test-psalm
.PHONY: analyse

fix:
	vendor/bin/ecs check --fix
	vendor/bin/ecs check --config=ecs-recipe.php --fix
.PHONY: fix

validate: validate-composer validate-doctrine-schema validate-twig validate-yaml-files validate-yarn-packages
.PHONY: validate

test-behat: test-behat-without-javascript test-behat-with-javascript test-behat-with-cli
.PHONY: test-behat

validate-coding-standard:
	vendor/bin/ecs check
	vendor/bin/ecs check --config=ecs-recipe.php
.PHONY: validate-coding-standard

validate-composer:
	composer validate --strict
.PHONY: validate-composer

validate-doctrine-schema:
	bin/console doctrine:schema:validate -vvv
.PHONY: validate-doctrine-schema

validate-twig:
	bin/console lint:twig src/Monofony/MetaPack/CoreMeta/.recipe/templates
	bin/console lint:twig src/Monofony/MetaPack/AdminMeta/.recipe/templates
	bin/console lint:twig src/Monofony/MetaPack/FrontMeta/.recipe/templates
.PHONY: validate-twig

validate-yaml-files:
	bin/console lint:yaml config --parse-tags
.PHONY: validate-yaml-files

validate-yarn-packages:
	yarn check
.PHONY: validate-yarn-packages

validate-package-version:
	vendor/bin/monorepo-builder validate
.PHONY: validate-package-version

test-phpspec:
	phpdbg -qrr vendor/bin/phpspec run --no-interaction -f dot
.PHONY: test-phpspec

test-phpstan:
	vendor/bin/phpstan analyse -c phpstan.neon
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
	vendor/bin/behat --colors --strict --no-interaction -vvv -f progress --tags="@cli&&~@todo" || vendor/bin/behat --strict --no-interaction -vvv -f progress --tags="@cli&&~@todo" --rerun
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
	vendor/bin/behat --colors --strict --no-interaction -vvv -f progress --tags="~@javascript&&~@todo&&~@cli" || vendor/bin/behat --strict --no-interaction -vvv -f progress --tags="~@javascript&&~@todo&&~@cli" --rerun
.PHONY: test-behat-without-javascript

test-behat-with-javascript:
	vendor/bin/behat --strict --no-interaction -vvv -f progress --tags="@javascript&&~@todo&&~@cli"
.PHONY: test-behat-with-javascript

test-fixtures:
	bin/console doctrine:fixtures:load --no-interaction
.PHONY: test-fixtures

install-package:
	(cd $(path) && composer update --no-interaction --prefer-dist --no-scripts --no-plugins)
.PHONY: install-package

test-package-phpstan:
	(cd $(path) && vendor/bin/phpstan analyse -c phpstan.neon)
.PHONY: test-package-phpstan

clean-package:
	(rm -rf $(path)/vendor)
	(rm $(path)/composer.lock)
.PHONY: clearn-package

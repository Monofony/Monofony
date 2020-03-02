include src/Monofony/Bundle/CoreBundle/Makefile
include src/Monofony/Bundle/AdminBundle/Makefile
include src/Monofony/Bundle/FrontBundle/Makefile
include src/Monofony/Plugin/FixturesPlugin/Makefile

test: validate test-phpspec analyse test-phpunit test-installer test-fixtures test-behat test-doctrine-migrations
.PHONY: test

analyse: test-phpstan test-psalm
.PHONY: analyse

validate: validate-composer validate-composer-security validate-doctrine-schema validate-twig validate-yaml-files validate-yarn-packages
.PHONY: validate

test-behat: test-behat-without-javascript test-behat-with-javascript test-behat-with-cli
.PHONY: test-behat

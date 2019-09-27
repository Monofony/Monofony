#!/usr/bin/env bash

source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/../../../bash/common.lib.sh"

code=0
commands=(
    validate-composer
    validate-composer-security
    validate-doctrine-schema
    validate-twig
    validate-yaml-files
    test-phpspec
    test-phpstan
    test-psalm
    test-phpunit
    test-installer
    test-fixtures
    test-infection
    test-behat-without-javascript
    test-behat-with-javascript
    test-behat-with-cli
    test-doctrine-migrations
    test-prod-requirements
)

for command in ${commands[@]}; do
    "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/script/${command}" || code=$?
done

exit ${code}

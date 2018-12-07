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
    test-phpunit
    test-installer
    test-fixtures
    test-infection
    test-behat-without-javascript
    test-behat-with-javascript
)

for command in ${commands[@]}; do
    "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/script/${command}" || code=$?
done

exit ${code}

#!/usr/bin/env bash

code=0
commands=(
    validate-composer
    validate-doctrine-schema
    test-phpspec
    test-phpunit
    test-fixtures
    test-behat-without-javascript
    test-behat-with-javascript
)

for command in ${commands[@]}; do
    "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/test/${command}" || code=$?
done

exit ${code}

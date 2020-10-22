#!/usr/bin/env bash

source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/../../../bash/common.lib.sh"
source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/packages.sh"

code=0
PHPSTAN_LEVEL=1

for package in ${packages[@]}; do
    print_header "Testing ${package}" "Monofony"

    run_command "(cd $(dirname ${BASH_SOURCE[0]})/../../../../src/Monofony/${package} && vendor/bin/phpstan analyse -c phpstan.neon -l ${PHPSTAN_LEVEL} ./)"
done

exit ${code}


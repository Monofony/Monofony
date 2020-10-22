#!/usr/bin/env bash

source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/../../../bash/common.lib.sh"
source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/packages.sh"

code=0

for package in ${packages[@]}; do
    print_header "Installing ${package}" "Monofony"

    run_command "(cd $(dirname ${BASH_SOURCE[0]})/../../../../src/Monofony/${package} && composer install --no-scripts --no-plugins)"
done

exit ${code}


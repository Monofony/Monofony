#!/usr/bin/env bash

source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/../../../bash/common.lib.sh"
source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/packages.sh"

code=0

for package in ${packages[@]}; do
    print_header "Installing ${package}" "Monofony"

    run_command "make install-package path=src/Monofony/${package}"
done

exit ${code}


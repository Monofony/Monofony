#!/usr/bin/env bash

source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/../../../bash/common.lib.sh"
source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/packages.sh"

code=0

run_test() {
  run_phpstan
}

run_phpstan() {
  if [[ ! -e "$(dirname ${BASH_SOURCE[0]})/../../../../src/Monofony/${package}/phpstan.neon" ]]; then
      return 0
  fi

  PHPSTAN_LEVEL=1

  print_header "Testing (PHPStan) ${package}" "Monofony"
  run_command "(cd ${package_dir} && vendor/bin/phpstan analyse -c phpstan.neon -l ${PHPSTAN_LEVEL} ./)"
}

clean_package() {
  rm -rf ${package_dir}/vendor
  rm -rf ${package_dir}/composer.lock
}

for package in ${packages[@]}; do
    package_dir=$(dirname ${BASH_SOURCE[0]})/../../../../src/Monofony/${package}

    run_test || code=$?
    clean_package
done

exit ${code}

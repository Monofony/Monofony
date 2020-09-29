#!/usr/bin/env bash

source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/../../../bash/common.lib.sh"

if [[ $TRAVIS_EVENT_TYPE == "push" && $TRAVIS_BRANCH == "${MAIN_BRANCH}" ]]; then
    run_command "vendor/bin/monorepo-builder split -v"
fi

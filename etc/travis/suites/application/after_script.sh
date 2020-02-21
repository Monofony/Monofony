#!/usr/bin/env bash

if [[ $TRAVIS_EVENT_TYPE == "push" && $TRAVIS_BRANCH == "master" ]]; then
    vendor/bin/monorepo-builder split -v
fi

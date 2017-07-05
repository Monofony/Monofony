#!/bin/bash

function log() {
    echo -e "$(date '+%b %d %T.%N') VAGRANT_PROVISIONING: $*"
}

function plog() {
    echo "──────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────"
    log "$*"
}

function raiseError() {
    log "$*"
    exit 1
}
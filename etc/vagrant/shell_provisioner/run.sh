#!/bin/bash

# Shell provisioner
PROVISONER_PATH=/vagrant/shell_provisioner
MODULE_PATH=$PROVISONER_PATH/module
CONFIG_PATH=$PROVISONER_PATH/config

# IP for the vagrant VM
GUEST_IP='10.0.0.200'

#Config
APP_DOMAIN='app_name.dev'
APP_DBNAME='app_name'

# Adding an entry here executes the corresponding .sh file in MODULE_PATH
DEPENDENCIES=(
    debian
    tools
    php
    mysql
    apache
    node
)

source $PROVISONER_PATH/helpers/plog.sh
for MODULE in ${DEPENDENCIES[@]}; do
    plog "Entering '$MODULE' provisioning"
    source ${MODULE_PATH}/${MODULE}.sh
    plog "Finished '$MODULE' provisioning"
done

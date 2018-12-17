#!/bin/bash

# Shell provisioner
PROVISONER_PATH=/vagrant/shell_provisioner
MODULE_PATH=$PROVISONER_PATH/module
CONFIG_PATH=$PROVISONER_PATH/config

# IP for the vagrant VM
GUEST_IP='10.0.0.200'

#Config
APP_DOMAIN='app_name.local'
APP_DBNAME='app_name'

# Adding an entry here executes the corresponding .sh file in MODULE_PATH
DEPENDENCIES=(
    debian
    tools
    php
    mysql
    apache
    node
    yarn
)

APT_CACHE=/home/mobizel/aptCacheDirectory

echo $APT_CACHE/archives

if [ -e "$APT_CACHE" ]; then
  mkdir -p $APT_CACHE/archives/
  find $APT_CACHE/archives -name '*.deb' -exec cp -f {} /var/cache/apt/archives/ \;
fi

source $PROVISONER_PATH/helpers/plog.sh
for MODULE in ${DEPENDENCIES[@]}; do
    plog "Entering '$MODULE' provisioning"
    source ${MODULE_PATH}/${MODULE}.sh
    plog "Finished '$MODULE' provisioning"
done

if [ -e "$APT_CACHE" ]; then
  rsync -ua --progress /var/cache/apt/archives/*.deb /home/mobizel/aptCacheDirectory/archives/
fi
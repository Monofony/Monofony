#!/bin/bash

plog "Installing useful tools such as zip, curl etc."
apt-get install -y zip unzip curl git vim

plog "Installing some aliases"
cat >> /home/vagrant/.bashrc <<EOF
alias ll='ls -l'
alias la='ls -A'
alias l='ls -CF'

alias www='cd /var/www/$APP_DBNAME'
alias db='mysql -uroot -pvagrant ${APP_DBNAME}_dev'
EOF
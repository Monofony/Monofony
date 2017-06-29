#!/bin/bash

plog "Setting locales"
sed -i 's/# fr_FR.UTF-8 UTF-8/fr_FR.UTF-8 UTF-8/' /etc/locale.gen
locale-gen
# echo 'LANG=fr_FR.UTF-8' > /etc/default/locale

plog "Setting timezone"
echo "Europe/Paris" > /etc/timezone
dpkg-reconfigure -f noninteractive tzdata

plog "Setting keyboard layout"
sed -i 's/XKBLAYOUT=.*/XKBLAYOUT="fr"/' /etc/default/keyboard
setupcon --force

plog "Setting hostname in /etc/hosts"
echo 127.0.0.1 $APP_DOMAIN >> /etc/hosts

plog "Adding dotdeb repository to the list of available ones"
wget https://www.dotdeb.org/dotdeb.gpg
sudo apt-key add dotdeb.gpg

cat << EOF >/etc/apt/sources.list.d/dotdeb.list
deb http://packages.dotdeb.org jessie all
deb-src http://packages.dotdeb.org jessie all
EOF

plog "Updating apt-get database"
apt-get update


#!/bin/bash

plog "Instaling apache2 and its dependencies"
apt-get install -y apache2 libapache2-mod-fcgid
a2enmod rewrite expires headers proxy proxy_http proxy_fcgi actions fastcgi alias ssl

plog "Activating virtual host"
a2dissite 000-default

chmod -R a+rX /var/log/apache2
sed -i 's/640/666/' /etc/logrotate.d/apache2

plog "Setting up ports to listen"
echo 'Listen 80
      Listen 443
' >  /etc/apache2/ports.conf

plog "Adding application to the available sites"
cat ${CONFIG_PATH}/apache/app.vhost.conf > /etc/apache2/sites-available/app.conf
a2ensite app.conf

plog "Restarting apache2"
service apache2 restart

#!/bin/bash

plog "Installing node.js"
curl -sL https://deb.nodesource.com/setup_4.x | sudo -E bash -
apt-get install -y nodejs

plog "Updating node packaged modules"
npm update -g npm
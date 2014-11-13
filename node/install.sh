#!/bin/bash

# DropPoint Installation Script
# Tested for Rasbian on Raspberry Pi Model B
if [[ $EUID -ne 0 ]]; then
   echo "This script must be run as root" 1>&2
   exit 1
fi
apt-get install tor openssh-server
service tor stop
rm -rf /var/lib/tor/droppoint/
mkdir /var/lib/tor/droppoint/
echo "HiddenServiceDir /var/lib/tor/droppoint/" >> /etc/tor/torrc
echo "HiddenServicePort 22 127.0.0.1:22" >> /etc/tor/torrc
chown debian-tor:debian-tor /var/lib/tor/droppoint/
service tor start

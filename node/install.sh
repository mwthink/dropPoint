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
# TODO : Add hidden service to torrc here
service tor start

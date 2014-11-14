#!/bin/bash

# DropPoint Installation Script
# Tested for Rasbian on Raspberry Pi Model B

# Configure these settings to your needs
homeServer="wsw5ippezfbzflr5.onion"
secretCode="changeThisCode";

# DO NOT EDIT ANYTHING BELOW THIS LINE

if [[ $EUID -ne 0 ]]; then
   echo "This script must be run as root" 1>&2
   exit 1
fi

command -v tor >/dev/null 2>&1 || { echo >&2 "Installation of 'tor' not found. Exiting"; exit 1; }
command -v torify >/dev/null 2>&1 || { echo >&2 "Installation of 'torify' not found. Exiting"; exit 1; }
command -v curl >/dev/null 2>&1 || { echo >&2 "Installation of 'curl' not found. Exiting"; exit 1; }

x=$(tor --verify-config | grep 'Configuration was valid')
if [[ $x != 'Configuration was valid' ]];then
	echo "Error detected in torrc file. Run 'tor --verify-config' to get details"
fi
x=$(cat /etc/tor/torrc | grep -v '^#' | grep 'HiddenServiceDir' | grep 'droppoint')
if [[ $x == $(grep '' /dev/null) ]];then
	echo "No DropPoint detected"
	echo "Creating DropPoint"
	mkdir /var/lib/tor/droppoint
	echo "HiddenServiceDir /var/lib/tor/droppoint/" >> /etc/tor/torrc
	echo "HiddenServicePort 80 127.0.0.1:80" >> /etc/tor/torrc
	chown debian-tor:debian-tor /var/lib/tor/droppoint
	echo "DropPoint created"
	echo "Restarting tor service"
	service tor restart
	
else
	echo "DropPoint found"
fi

if [ ! -f /var/lib/tor/droppoint/hostname ]
then
    echo "FATAL - The DropPoint does not seem to have a hostname"
    echo "Is tor running and does it own /var/lib/tor/droppoint?"
    exit 1
fi
tput setaf 2; echo "Your DropPoint hostname is :" $(cat /var/lib/tor/droppoint/hostname);tput sgr0
echo "Calling home server @ $homeServer"


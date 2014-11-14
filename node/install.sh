#!/bin/bash

# DropPoint Installation Script
# Tested for Rasbian on Raspberry Pi Model B
if [[ $EUID -ne 0 ]]; then
   echo "This script must be run as root" 1>&2
   exit 1
fi
command -v tor >/dev/null 2>&1 || { echo >&2 "Installation of 'tor' not found. Exiting"; exit 1; }

x=$(tor --verify-config | grep 'Configuration was valid')
if [[ $x != 'Configuration was valid' ]];then
	echo "Error detected in torrc file. Run 'tor --verify-config' to get details"
fi
x=$(cat /etc/tor/torrc | grep -v '^#' | grep 'HiddenServiceDir' | grep 'droppoint')
if [[ $x == $(grep '' /dev/null) ]];then
	echo "No DropPoint detected"
fi

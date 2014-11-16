#!/bin/bash

# DropPoint Installation Script
# Tested for Rasbian on Raspberry Pi Model B

# Configure these settings to your needs
homeServer="http://mysite.onion/report.php"
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
if [ ! -f /var/lib/tor/droppoint/cron.sh ]
then
	echo "Cronfile not installed"
	echo "Adding to /var/lib/tor/droppoint/"
    cp $0 /var/lib/tor/droppoint/cron.sh
    echo "Adding to crontab for root"
    crontab -l > cron.tmp
    echo "*/5 * * * * /var/lib/tor/droppoint/cron.sh" >> cron.tmp
    crontab cron.tmp
    rm cron.tmp
    echo "Added to cron jobs"
fi
if [ -f /var/lib/tor/droppoint/authKey ]
then
	echo "Authentication code detected"
    secretCode=$(cat /var/lib/tor/droppoint/authKey)
fi
echo "Calling home server @ $homeServer"
# TODO: Clean this up. Set variable from wget or curl or something
command=$homeServer"?code=$secretCode&domain=$(cat /var/lib/tor/droppoint/hostname)"
torify wget -q $command -O output.tmp
result=$(cat output.tmp)
rm output.tmp
clear
echo "ALL DONE!"
tput setaf 2; echo "Your DropPoint hostname is :" $(cat /var/lib/tor/droppoint/hostname);tput sgr0
if [ $result == "1" ]
then
	echo "New registration added to server directory"
	echo "Fetching auth key";
	command=$homeServer"?code=$secretCode&domain=$(cat /var/lib/tor/droppoint/hostname)&getAuth"
	torify wget -q $command -O output.tmp
	result=$(cat output.tmp)
	rm output.tmp
	echo $result >> /var/lib/tor/droppoint/authKey
	tput setaf 2;echo "Successfully added new server to master directory";tput sgr0
elif [ $result == "2" ]
then
	tput setaf 2;echo "Successfully updated server listing";tput sgr0
else
	tput setaf 1;echo "An error occurred while adding/updating server listing";tput sgr0
	echo "Error code: $result"
fi

# DropPoint Installation
#### Remotely accessible Tor hidden service deployment suite

### Prerequisites
DropPoint requires that the following packages be installed:

#### Node
1. tor (Including torify and setup as system service)
2. curl

#### Control
The control package is PHP scripts. All you need is a working web server capable of processing PHP files. 
Unless you modify the medoo config, you will need to have php5-sqlite installed to read/write from the SQLite database


### Installation
#### Node
Installation of the node simply requires running the install.sh script with root permissions
The script will create a hidden service directory, add the appropriate entry to your torrc file and call home to your reporting server to notify that deployment was successful

#### Control
To install the control package, simply move the PHP files/folders to your web server directory. Set the base dir to the 'public' folder
You will need to setup an SQLite database named database.db inside the admin/lib/ folder with the appropriate tables (An installer is underway to automate this process)

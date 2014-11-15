# DropPoint
#### Remotely accessible Tor hidden service deployment suite

### Overview
DropPoint is a collection of software to make it easy to create  a remotely accessible machine over the Tor network. This can be used for a wide variety of scenarios in which setting up a typical remote access machine or gaining access to an existing machine is not possible.
A remotely accessible machines is known as a “node”. Nodes are meant to be easily deployed with a hands-off setup. Once a node is deployed, it will call the DropPoint control server to submit all of it’s connection information. 
### Node
Ideally, the node is a small computer, such as a Raspberry Pi (Official development hardware is a Raspberry Pi model B+ w/ optional Edimax EW-7811Un USB wireless adapter). The node is placed into an area where it has the ability to connect to the network and is turned on. As soon as the machine boots and it finds an Internet connection, the node will begin to connect to the Tor network. 
Assuming that the node is successful in connecting to Tor, the node will broadcast a message to the control server, notifying it of it’s current status and hidden service URL. Once the user sees this information in his control center, they can initiate a connection to their machine and do whatever is needed. 

### Control Center
The control center is a very simple web front-end for the monitoring of nodes. Nodes are preconfigured with both the control center’s .onion address and access key. When a node comes online, it broadcasts this data to the control center to validate it’s identity and appears as ‘Online’ to the user. The user can then initiate connection to the node. 

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
To install the control package, simply move the PHP files/folders to your web server directory. Set the base dir to the 'public' folder and follow the setup instructions upon first load

___
Want to help out? Donate BTC 1Lce24LcX3912Y7UxkQAYymVrgFq2kuER9

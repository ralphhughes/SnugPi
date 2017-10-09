# SnugPi
# Raspberry Pi Thermostat project

This is yet another Raspberry Pi thermostat as I wasn't happy with the cost\complexity\user interface of all the ones I tried. Mine is built using SQLite for persistence, PHP on the server side, and jQuery mobile for the GUI.


###### Screenshot

## Installation instructions

###### Install dependencies
`sudo apt-get install git nginx php5-fpm sqlite3 php5-sqlite`


###### Setup nginx
[https://www.raspberrypi.org/documentation/remote-access/web-server/nginx.md](Follow this raspberry pi official doc)

`sudo nano /etc/nginx/sites-enabled/default`
Add `index.php` after `index`
Uncomment `location .php {` section

###### Install code
`cd /var/www`

`git clone https://github.com/ralphhughes/SnugPi.git`

###### Browse to the web interface

Fire up your browser and point it at `http://ip-address-of-pi/SnugPi`

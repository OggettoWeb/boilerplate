Magento Boilerplate
===================

Boilerplate package provides a setup template for Magento project.

What's inside
-------------
Boilerplate includes [Vagrant](http://vagrantup.com) configuration with [puppet](http://puppetlabs.com) scripts to setup a virtual machine.
These puppet scripts could be used to setup a local VM for developers as well as remote server.

Quick overview of virtual machine:

* Debian Linux
* NGINX Web Server + PHP 5.4 with minimum required modules set up
* [Composer](http://getcomposer.org), with some modules pre-installed
* MySQL 5.5 with databases set up
* RabbitMQ queue server
* Tool for database/media sync from remote dump to local machine
* PHPMyAdmin

See [VM info](https://github.com/OggettoWeb/boilerplate/wiki/Vm-info) for more details

Resources
---------

* [Installation](https://github.com/OggettoWeb/boilerplate/wiki/Installation)
* [Usage](https://github.com/OggettoWeb/boilerplate/wiki/Usage)
* [Detailed VM info](https://github.com/OggettoWeb/boilerplate/wiki/Vm-info)
* [Customization](https://github.com/OggettoWeb/boilerplate/wiki/Customization)

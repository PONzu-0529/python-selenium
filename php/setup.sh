#!/bin/sh

# Setup Appache rewrite_module
sudo a2enmod rewrite

# Change Owner
sudo chown -R 1000 /var/www/html/php/vendor

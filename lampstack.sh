#!/bin/bash

####################################################################
#                                                                  # 
#                                     							   #
# Easier method to install LAMP in linux with mysql and phpmyadmin #
#                                                                  # 
#                                     							   #
####################################################################

sudo apt-get update
sudo apt-get upgrade

sudo apt-get install -y apache2
sudo apt-get install -y mysql-server
sudo apt-get install -y php libapache2-mod-php phpmcrypt php-mysql
sudo apt-get install -y phpmyadmin
sudo apt-get install -y php7.0-mbstring php7.0-bcmath php-amqp php7.0-cli git
sudo apt-get install -y erlang

# Create a symbolic link to attach php7.0 with apache2 #

sudo ln -s /etc/phpmyadmin/apache.conf /etc/apache2/conf-available/phpmyadmin.conf
sudo a2enconf phpmyadmin.conf
sudo service apache2 reload

# Install Rabbit MQ #

sudo apt-get install -y rabbitmq-server

# Create symbolic link to attach rabbitmq with php7.0 and apache2 #

cd /etc/php/7.0/mods-available
sudo sh -c "echo 'extension=amqp.so' >> amqp.ini"

cd /etc/php/7.0/cli/conf.d
sudo ln -s /etc/php/7.0/mods-available/amqp.ini

cd /etc/php/7.0/apache2/conf.d
sudo ln -s /etc/php/7.0/mods-available/amqp.ini

# Restart the service for the apache2 server #

sudo service apache2 restart


#!/usr/bin/env bash

# set timezone
ln -sf /usr/share/zoneinfo/Europe/Zurich /etc/localtime

# mysql settings
debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password password rootpass'
debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password_again password rootpass'

# phpmyadmin settings
debconf-set-selections <<< 'phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2'
debconf-set-selections <<< 'phpmyadmin phpmyadmin/dbconfig-install boolean true'
debconf-set-selections <<< 'phpmyadmin phpmyadmin/mysql/admin-pass password rootpass'
debconf-set-selections <<< 'phpmyadmin phpmyadmin/mysql/app-pass password rootpass'
debconf-set-selections <<< 'phpmyadmin phpmyadmin/app-password-confirm password rootpass'

apt-get update
apt-get install -y apache2-mpm-prefork php5 mysql-server php5-curl php5-dev php5-gd php5-idn php5-imagick php5-imap php5-mysql php-pear
a2enmod suexec rewrite ssl actions include vhost_alias

# show php errors
sudo sed -i '/display_errors = Off/c display_errors = On' /etc/php5/apache2/php.ini

# from www.thisprogrammingthing.com/2013/getting-started-with-vagrant/
if [ ! -f /var/log/databasesetup ];
then
        echo "CREATE USER 'loc_orm'@'localhost' IDENTIFIED BY '12341234'" | mysql -uroot -prootpass
        echo "CREATE DATABASE loc_orm" | mysql -uroot -prootpass
        echo "GRANT ALL ON loc_orm.* TO 'loc_orm'@'localhost'" | mysql -uroot -prootpass
        echo "flush privileges" | mysql -uroot -prootpass

        touch /var/log/databasesetup

        if [ -f /vagrant/initial.sql ];
        then
                mysql -uroot -prootpass loc_orm < /vagrant/initial.sql
        fi
fi

# phpmyadmin
sudo apt-get install -y phpmyadmin
echo 'Include /etc/phpmyadmin/apache2.conf' >> /etc/apache2/apache.conf

# php unit
pear config-set auto_discover 1
pear install pear.phpunit.de/PHPUnit
pear install pear.phpunit.de/PHPUnit_Selenium

# yii
yes | trackstar/protected/yiic migrate

# restart apache
service apache2 restart

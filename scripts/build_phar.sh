#!/bin/sh
# Builds an single php-autoloader-test.phar file that can run standone

composer.phar install --no-dev
wget http://www.lueck.tv/phar-composer/phar-composer.phar -O /tmp/phar-composer.phar
rm -rf build && mkdir build
php /tmp/phar-composer.phar build . build/php-autoloader-test.phar

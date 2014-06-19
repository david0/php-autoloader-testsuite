# PHP Autoloader Testsuite [![Build Status](https://travis-ci.org/david0/php-autoloader-testsuite.svg)](https://travis-ci.org/david0/php-autoloader-testsuite)

A testsuite for verifying autoloaders. This script will scan your project for tokens that would trigger the autoload chain. By suppling your bootstrap script it will try to load all classes and interfaces using your own autoload chain.

# Usage

[Download](https://github.com/david0/php-autoloader-testsuite/releases) `php-autoloader-test.phar` and run using

    cd <your-project-root>
    php php-autoloader-test.phar <your bootstrap script> <path-to-sources>

Where the bootstrap script is is the script that registers your autoloaders and sets the include paths.

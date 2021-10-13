#!/usr/bin/with-contenv php
<?php

$xdebug = getenv('XDEBUG_ENABLE');
if ('1' === $xdebug) {
    file_put_contents('/etc/php7/conf.d/50_xdebug.ini', "zend_extension=xdebug.so\n");
}

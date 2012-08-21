<?php
/**
 * Bootstrap of Example application
 *
 * @author gdievart <dievartg@gmail.com>
 */

use Telco\Autoloader\Autoloader;
use Telco\Conf\Conf;

Autoloader::addAlias(array(
    'Example'      => ROOT_DIR.'app/Example'
));

Conf::mergeConfig(__DIR__.'/etc/config.ini');
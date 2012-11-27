<?php
/**
 * Bootstrap of Example application
 *
 * @author gdievart <dievartg@gmail.com>
 */

use Telelab\Autoloader\Autoloader;
use Telelab\Conf\Conf;

Autoloader::addAlias(array(
    'Example'      => ROOT_DIR.'app/Example'
));

Conf::mergeConfig(__DIR__.'/etc/config.ini');
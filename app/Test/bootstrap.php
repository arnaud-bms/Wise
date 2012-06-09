<?php
/**
 * Bootstrap of Test application
 *
 * @author gdievart
 */

use Telco\Autoloader\Autoloader;
use Telco\Conf\Conf;

Autoloader::addAlias(array(
    'Test'      => ROOT_DIR.'app/Test',
    'PlugTest'  => ROOT_DIR.'plugins/PlugTest'
));

Conf::mergeConfig(__DIR__.'/etc/config.ini');
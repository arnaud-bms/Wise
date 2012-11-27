<?php
/**
 * Bootstrap of {{app_name}} application
 *
 * @author {{user}}
 */

use Telelab\Autoloader\Autoloader;
use Telelab\Conf\Conf;

Autoloader::addAlias(array(
    '{{app_name}}'  => ROOT_DIR.'app/{{app_name}}'
));

Conf::mergeConfig(__DIR__.'/etc/config.ini');
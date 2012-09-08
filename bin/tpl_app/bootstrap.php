<?php
/**
 * Bootstrap of {{app_name}} application
 *
 * @author {{user}}
 */

use Telco\Autoloader\Autoloader;
use Telco\Conf\Conf;

Autoloader::addAlias(array(
    '{{app_name}}'  => ROOT_DIR.'app/{{app_name}}'
));

Conf::mergeConfig(__DIR__.'/etc/config.ini');
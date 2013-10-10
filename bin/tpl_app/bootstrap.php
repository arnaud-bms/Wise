<?php
/**
 * Bootstrap of {{app_name}} application
 *
 * @author {{user}}
 */

use Telelab\Conf\Conf;

$loader = require ROOT_DIR.'/vendor/autoload.php';
$loader->add('{{app_name}}', __DIR__);

Conf::mergeConfig(__DIR__.'/etc/config.ini');
Conf::mergeConfig(__DIR__.'/etc/routing.ini');
Conf::mergeConfig(__DIR__.'/etc/view.ini');
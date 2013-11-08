<?php
/**
 * Bootstrap of {{app_name}} application
 *
 * @author {{user}}
 */

use Telelab\Conf\Conf;

$loader = require ROOT_DIR.'/vendor/autoload.php';
$loader->add('{{app_name}}', ROOT_DIR.'/app');

Conf::mergeConfig(__DIR__.'/etc/config.php');
Conf::mergeConfig(__DIR__.'/etc/routing.php');
Conf::mergeConfig(__DIR__.'/etc/view.php');
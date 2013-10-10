<?php
/**
 * Default configuration for UnitTests
 */

use Telelab\Conf\Conf;

define('ROOT_DIR', __DIR__.'/../');
require_once ROOT_DIR.'/vendor/autoload.php';

Conf::loadConfig(ROOT_DIR.'app/etc/app.ini');
Conf::mergeConfig(ROOT_DIR.'app/etc/routing.ini');
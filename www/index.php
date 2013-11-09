<?php

define('ROOT_DIR', realpath(__DIR__.'/..').'/');
require ROOT_DIR.'vendor/autoload.php';

\Wise\Conf\Conf::merge(ROOT_DIR.'app/etc/route_apps.php');

$router = new Wise\Router\Router();
$dispatcher = new Wise\Dispatcher\Dispatcher($router);
$dispatcher->run();
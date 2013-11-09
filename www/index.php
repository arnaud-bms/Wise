<?php

define('ROOT_DIR', realpath(__DIR__.'/..').'/');
require ROOT_DIR.'vendor/autoload.php';
require ROOT_DIR.'core/Wise/Core/Core.php';

/*\Wise\Conf\Conf::set(
    'route_apps',
    array('test' => array(
        'prefix' => '/',
        'app' => 'Test',
    ))
);*/

\Wise\Conf\Conf::load(ROOT_DIR.'app/etc/core.php');
\Wise\Conf\Conf::load(ROOT_DIR.'app/etc/route_apps.php');

$router = new Wise\Router\Router();
$dispatcher = new Wise\Dispatcher\Dispatcher($router);
$dispatcher->run();
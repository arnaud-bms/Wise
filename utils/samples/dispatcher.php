<?php

/**
 * examples \Wise\Dispatcher\Dispatcher
 * 
 * Examples of use of the Dispatcher component
 * 
 * @author gdievart <dievartg@gmail.com>
 */
define('ROOT_DIR', realpath(__DIR__).'/../../');
$autoload = require ROOT_DIR.'vendor/autoload.php';

$autoload->add('WisePlugin', __DIR__.'/../../src');

$config = array(
    'default' => array(
        'app_name'      => array(
            'sapi'      => 'cli'
        )
    ),
    'routes' => array(
        'app_name.home' => array(
            'pattern'   => '/',
            'action'    => function() { echo "Hello World!\n"; },
        )
    )
);

$router = new Wise\Router\Router($config);

$router->addRoute(
    'app_name.test', 
    array(
        'pattern' => '/([0-9]+)', 
        'action' => function($id = null) { echo $id."\n"; }
    )
);

$dispatcher = new \Wise\Dispatcher\Dispatcher($router);
$dispatcher->run();
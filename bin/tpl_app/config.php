<?php

return array(
    'globals' => array(
        'env' => 'dev'
    ),
    'route_error' => array(
        '404' => '/404'
    ),
    'exception_handler' => array(
        'class' => 'Telelab\ExceptionHandler\ExceptionHandler',
        'method' => 'catchException',
    ),
    'error_handler' => array(
        'class' => 'Telelab\ErrorHandler\ErrorHandler',
        'method' => 'catchError',
    ),
    'db' => array(
        'driver' => 'mysqli',
        'host' => '',
        'dbname' => '',
        'user' => '',
        'password' => ''
    ),
    'redis' => array(
        'host' => '',
        'port' => 6379,
        'timeout' => 0,
        'prefix' => ''
    ),
    'cache' => array(
        'enable' => true,
        'driver' => 'memcache',
        'file' => array(
            'ttl' => 5,
            'path' => ROOT_DIR.'var/cache/core',
        ),
        'memcache' => array(
            'ttl' => 5,
            'host' => '127.0.0.1',
            'port' => 11211,
        ),
    ),
    'conf_cache' => array(
        'enable' => true,
        'driver' => 'memcache',
        'memcache' => array(
            'ttl' => 5,
            'host' => '127.0.0.1',
            'port' => 11211,
        ),
    ),
    'router_cache' => array(
        'enable' => true,
        'driver' => 'memcache',
        'memcache' => array(
            'ttl' => 5,
            'host' => '127.0.0.1',
            'port' => 11211,
        ),
    ),
    'logger' => array(
        'enable' => true,
        'driver' => 'file',
        'output' => false,
        'log_level' => 'DEBUG',
        'file' => array(
            'file' => ROOT_DIR.'var/log/core.log'
        )
    ),
    'view' => array(
        'driver' => 'php',
        'default_template' => 'main.php',
        'smarty' => array(
            'template_dir' => ROOT_DIR.'tpl',
            'compile_dir' => ROOT_DIR.'var/cache/tpl_c',
        ),
        'php' => array(
            'template_dir' => ROOT_DIR.'app/{{app_name}}/tpl'
        )
    ),
    'mailer' => array(
        'host_default' => '127.0.0.1',
        'host_attachments' => '127.0.0.1',
    ),
    'generate' => array(
        'dir' => '127.0.0.1',
        'alias' => array(
            'test:home:([a-z]+)' => 'index-$1.html'
        ),
    ),
    'firewall' => array(
        'redirect' => '/auth',
        'redirect_type' => 'bg',
        'route' => array(
            'client_test'
        ),
    ),
    'file' => array(
        'path' => ROOT_DIR.'var/tmp/upload',
        'ext' => array(
            'png',
            'jpeg',
            'jpg'
        ),
        'max_size' => array(
            'png' => 1048576,
            'jpeg' => 1048576,
            'jpg' => 1048576,
        ),
    ),
);

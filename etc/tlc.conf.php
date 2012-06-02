<?php
/**
 * Global configuration file
 */
$configTlc = array(
    'environment' => 'DEV',
    'autoloader' => array(
        'class'     => '\Tlc\Autoloader\Autoloader',
        'method'    => 'registerAutoload',
        'path'      => realpath(__DIR__ . '/..') . '/lib/Tlc/Autoloader/Autoloader.class.php',
    ),
    'exception_handler' => array(
        'class'     => '\Tlc\ExceptionHandler\ExceptionHandler',
        'method'    => 'catchException'
    ),
    'error_handler' => array(
        'class'     => '\Tlc\ErrorHandler\ErrorHandler',
        'method'    => 'catchError'
    ),
    'logger' => array(
        'dir'      => realpath(__DIR__ . '/..') . '/var/log/'
    )
);
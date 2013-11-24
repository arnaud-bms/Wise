<?php

/**
 * examples \Wise\Logger\Logger
 * 
 * Examples of use of the Logger component
 * 
 * @author gdievart <dievartg@gmail.com>
 */
define('ROOT_DIR', realpath(__DIR__).'/../../');
require ROOT_DIR.'vendor/autoload.php';

$config = array(
    'name'        => 'DEFAULT',
    'date_format' => 'Y-m-d H:i:s',
    'format'      => "[%datetime%] [%channel%] [%level_name%] %message% %context% %extra%\n",
    'handler'     => array(
        array(
            'type'      => 'stream',
            'options'   => '/tmp/alerting',
            'log_level' => 'error'
        ),
        array(
            'type'      => 'stream',
            'options'   => '/tmp/debug',
            'log_level' => 'debug'
        )
    )
);

$logger = new \Wise\Logger\Logger($config);

// Added a callback
$logger->addProcessor(function($record) {
    $record['extra']['loadAvg'] = sys_getloadavg();
    
    return $record;
});

// write log
$logger->debug('Bonjour {prenom}', array('prenom' => 'Guillaume'));
$logger->error('test');

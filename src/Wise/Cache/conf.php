<?php

/**
 * The default configuration for the Cache component
 */
return array(
    'cache' => array(
        'enable' => true,
        'driver' => 'memcache', // the default driver
        'file'   => array(
            'ttl'  => 300,
            'path' => "/tmp/cache",
        ),
        'memcache' => array(
            'ttl'  => 300,
            'host' => '127.0.0.1',
            'port' => 11211,
        ),
    )
);
<?php

/**
 * Configuration file of the Cache component
 */
return array(
    'cache' => array(
        'enable' => true,
        'driver' => 'memcache',
        'file' => array(
            'ttl' => 5,
            'path' => ROOT_DIR."var/cache/core",
        ),
        'memcache' => array(
            'ttl' => 5,
            'host' => '127.0.0.1',
            'port' => 11211,
        ),
    )
);
<?php

/**
 * examples \Wise\Cache\Cache
 * 
 * Examples of use of the Cache component
 * 
 * @author gdievart <dievartg@gmail.com>
 */
define('ROOT_DIR', realpath(__DIR__).'/../../');
require ROOT_DIR.'vendor/autoload.php';

$config = array(
    'driver'   => 'memcache',
    'enable'   => true,
    'memcache' => array(
        'ttl'  => 5,
        'host' => '127.0.0.1',
        'port' => 11211
    )
);

$cache = new \Wise\Cache\Cache($config);

$cache->set('ma_cle', 'Mon contenu', 5);
echo $cache->get('ma_cle')."\n";
sleep(5);
echo $cache->get('ma_cle')."\n";

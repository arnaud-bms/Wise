<?php

/**
 * examples \Wise\String\String
 * 
 * Examples of use of the String component
 * 
 * @author gdievart <dievartg@gmail.com>
 */
define('ROOT_DIR', realpath(__DIR__).'/../');
require ROOT_DIR.'vendor/autoload.php';

$conf = array(
    'options' => array(
        'header'         => true,  
        'nobody'         => true,
        'returntransfer' => true,
        'maxredirs'      => 10,
        'followlocation' => 1,
        'useragent' => 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:24.0) Gecko/20100101 Firefox/24.0',
    )
);

$curl = new \Wise\Curl\Curl($conf);

$curl->setUrl('http://www.google.fr');
echo $curl->exec();

print_r($curl->getInfo());
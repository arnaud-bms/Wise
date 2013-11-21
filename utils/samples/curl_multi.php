<?php

/**
 * examples \Wise\Curl\Multi
 * 
 * Examples of use of the \Wise\Curl\Multi component
 * 
 * @author gdievart <dievartg@gmail.com>
 */
define('ROOT_DIR', realpath(__DIR__).'/../../');
require ROOT_DIR.'vendor/autoload.php';

$conf = array('timeout' => 3);
$multi = new \Wise\Curl\Multi($conf);

$conf = array(
    'options' => array(
        'header'         => true,  
        'nobody'         => true,
        'returntransfer' => true,
    )
);

$curlId_1 = $multi->addRequest('http://www.google.com', $conf);
$curlId_2 = $multi->addRequest('http://www.google.com', $conf);

$multi->request();

echo $multi->getResponse($curlId_1);
echo $multi->getResponse($curlId_2);
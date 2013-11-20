<?php

/**
 * examples \Wise\Conf\Conf
 * 
 * Examples of use of the String component
 * 
 * @author gdievart <dievartg@gmail.com>
 */
define('ROOT_DIR', realpath(__DIR__).'/../');
require ROOT_DIR.'vendor/autoload.php';

$configuration = array(
  'examples' => array(
      'first' => 1,
      'last'  => 10
  )  
);

// Load the configuration from array
\Wise\Conf\Conf::load($configuration);

// Display the value of examples.first
echo \Wise\Conf\Conf::get('examples.first')."\n";

// Modify and display the value of examples.first
\Wise\Conf\Conf::set('examples.first', 2);
echo \Wise\Conf\Conf::get('examples.first')."\n";
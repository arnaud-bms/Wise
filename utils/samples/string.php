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

echo Wise\String\String::upper('Hello World !')."\n";

echo Wise\String\String::camelcase('Hello_world_!')."\n";

echo Wise\String\String::camelcaseToUnderscores('HelloWorld!')."\n";

echo Wise\String\String::lower('Hello World !')."\n";

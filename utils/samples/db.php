<?php

/**
 * examples \Wise\String\String
 * 
 * Examples of use of the String component
 * 
 * @author gdievart <dievartg@gmail.com>
 */
define('ROOT_DIR', realpath(__DIR__).'/../../');
require ROOT_DIR.'vendor/autoload.php';

$config = array(
    'driver'   => 'mysqli',
    'host'     => 'localhost',
    'user'     => 'root',
    'password' => '**********',
    'dbname'   => 'test',
);
$db = new \Wise\Db\Db($config);

$stmt = $db->query('SELECT * FROM employee LIMIT 2');
while($row = $stmt->fetch()) {
    print_r($row);
}

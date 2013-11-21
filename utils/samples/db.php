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

$config = array(
    'driver'   => 'pdo',
    'host'     => '127.0.0.1',
    'user'     => 'root',
    'password' => '*********',
    'dbname'   => 'test',
);
$db = new \Wise\DB\DB($config);

$stmt = $db->query('select * from employee2');
while($row = $stmt->fetch()) {
    print_r($row);
    die;
}

<?php
namespace Test;

use Tlc\Controller\Controller;
use Tlc\Conf\Conf;

/**
 * Description of Main
 *
 * @author gdievart
 */
abstract class TestController extends Controller 
{
    
    public function __construct()
    {
        Conf::mergeConfig(__DIR__ . '/etc/config.ini');
    }
}

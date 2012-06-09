<?php
namespace Test;

use Telco\Controller\Controller;
use Telco\Conf\Conf;

/**
 * Description of Main
 *
 * @author gdievart
 */
abstract class TestController extends Controller 
{
    
    /**
     * Merge configuration app Test 
     */
    public function __construct()
    {
        Conf::mergeConfig(__DIR__.'/etc/config.ini');
    }
}

<?php
namespace Test\Controllers;

use Test\TestController;
use Tlc\DB\DB;
use Tlc\Conf\Conf;

/**
 * Description of Main
 *
 * @author gdievart
 */
class Main extends TestController 
{
    
    /**
     * Method test
     * 
     * @param string $var 
     */
    public function index($var, $var2)
    {
        $db = new DB();
        $return = array($var, $var2);
        
        return $return;
    }
}

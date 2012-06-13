<?php
namespace Example\Controllers;

use Example\ExampleController;
use Telco\DB\DB;
use Telco\Bootstrap\Bootstrap;

/**
 * Description of Main
 *
 * @author gdievart
 */
class Main extends ExampleController 
{
    
    /**
     * Method test
     * 
     * @param string $var 
     */
    public function index($var, $var2)
    {
        $return['page'] = 'TOTO';
        
        return $return;
    }
    
    
    /**
     * Method redirect
     * 
     * @param string $var 
     */
    public function generateIndex($var, $var2)
    {
        Bootstrap::setProperty('generate', 'home');
        return $this->index($var, $var2);
    }
    
    
    /**
     * Method redirect
     * 
     * @param string $var 
     */
    public function redirect()
    {
        $this->_redirect('/Test titi chuc');
    }
}

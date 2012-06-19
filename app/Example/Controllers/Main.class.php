<?php
namespace Example\Controllers;

use Example\ExampleController;
use Telco\Bootstrap\Bootstrap;
use Telco\DB\Driver\Statement;

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
        $this->getRepository('Example\Models\TestRepository')->insert(array('name' => 'truc'));
        $stmt = $this->getRepository('Example\Models\TestRepository')->select('*');
        $return['rows'] = $stmt->fetchAll();
        $return['page'] = 'TOTO';
        
        $test['name'] = 'test';
        
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
        $this->_redirect('/Example/home titi chuc');
    }
}

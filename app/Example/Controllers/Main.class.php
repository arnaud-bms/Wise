<?php
namespace Example\Controllers;

use Example\ExampleController;
use Telco\Bootstrap\Bootstrap;
use Telco\DB\Driver\Statement;

/**
 * Description of Main
 *
 * @author gdievart <dievartg@gmail.com>
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
        $testRepository = $this->getRepository('Example\Models\TestRepository');
        
        $testRepository->insert(array('name' => uniqid()));
        
        $stmt = $testRepository->select('*');
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
     * 
     */
    public function generateList()
    {
        $testRepository = $this->getRepository('Example\Models\TestRepository');
        
        $stmt = $testRepository->select('*');
        $return['rows'] = $stmt->fetchAll();
        
        Bootstrap::setProperty('generate', 'list');
        
        return $return;
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

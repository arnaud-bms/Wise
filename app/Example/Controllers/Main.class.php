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
     * @param string $var 
     * @return array $response
     */
    public function index($var, $var2)
    {
        // Instanciate repository of the table test
        $testRepository = $this->getRepository('Example\Models\TestRepository');
        
        // Insert row in table test
        $testRepository->insert(array('name' => uniqid()));
        
        // Select all from table test
        $stmt = $testRepository->select('*');
        $response['rows'] = $stmt->fetchAll();
        
        $response['page'] = 'TOTO';
        
        // Set property format for plugin Format
        Bootstrap::setProperty('format', 'xml');
        
        return $response;
    }
    
    
    /**
     * Method redirect
     * 
     * @param string $var 
     */
    public function generateIndex($var, $var2)
    {
        Bootstrap::setProperty('format', 'xml');
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
        $response['rows'] = $stmt->fetchAll();
        
        Bootstrap::setProperty('format', 'xml');
        Bootstrap::setProperty('generate', 'list');
        
        return $response;
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

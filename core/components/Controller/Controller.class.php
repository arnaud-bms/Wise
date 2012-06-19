<?php
namespace Telco\Controller;

use Telco\Bootstrap\Bootstrap;

/**
 * Abstract Controller
 *
 * @author gdievart
 */
abstract class Controller 
{
    
    /**
     * @var array Repository loaded 
     */
    protected $_repositoryLoaded = array();
    
    /**
     * Redirect
     * 
     * @param type $route
     */
    protected function _redirect($route)
    {
        Bootstrap::run($route);
        Bootstrap::interruptRequest();
    }
    
    
    /**
     * Get ref to repository
     * 
     * @param string $repository 
     * @return Repository
     */
    public function getRepository($repository)
    {
        if(!isset($this->_repositoryLoaded[$repository])) {
            $this->_repositoryLoaded[$repository] = new $repository();
        }
        
        return $this->_repositoryLoaded[$repository];
    }
}

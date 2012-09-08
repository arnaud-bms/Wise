<?php
namespace Telco\Controller;

use Telco\FrontController\FrontController;

/**
 * Abstract Controller
 *
 * @author gdievart <dievartg@gmail.com>
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
        FrontController::run($route);
        FrontController::interruptRequest();
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

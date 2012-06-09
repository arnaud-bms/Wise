<?php
namespace Telco\Controller;

use Telco\Bootstrap\Bootstrap;
use Telco\Router\Router;

/**
 * Abstract Controller
 *
 * @author gdievart
 */
abstract class Controller 
{
    
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
}

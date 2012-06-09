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
     * @param type $type 
     */
    protected function _redirect($route, $type = Router::SAPI_CGI)
    {
        if($type === Router::SAPI_CGI) {
            $_SERVER['REQUEST_URI'] = $route;
        } else {
            $_SERVER['argv'][0] = '';
            $_SERVER['argv'] = array_merge($_SERVER['argv'], explode(' ', $route));
        }
        Bootstrap::run();
    }
}

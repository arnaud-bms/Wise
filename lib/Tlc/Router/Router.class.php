<?php
namespace Tlc\Router;

use \Tlc\Component\Component;

/**
 * Description of Bootstrap
 *
 * @author gdievart
 */
class Router extends Component 
{
    /**
     * Extract route informatios from argv
     * 
     * @return array 
     */
    public function getRouteInfosFromArgv()
    {
        $argv = $_SERVER['argv'];
        array_shift($argv);
        
        list($app, $controller, $method) = explode(':', array_shift($argv));
        
        return array(
            'app'        => $app,
            'controller' => $controller,
            'method'     => $method,
            'argv'       => $argv
        );
    }
    
    
    /**
     * Extract route informations from URI
     * 
     * @return array 
     */
    public function getRouteInfosFromURI()
    {
        print_r($_SERVER['REQUEST_URI']);
    }
}

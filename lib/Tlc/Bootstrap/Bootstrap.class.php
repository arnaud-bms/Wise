<?php
namespace Tlc\Bootstrap;

use \Tlc\Component\Component;

/**
 * Description of Bootstrap
 *
 * @author gdievart
 */
class Bootstrap extends Component 
{
    
    /**
     * Run application
     */
    public static function run() 
    {
        $router = new \Tlc\Router\Router();
        if(php_sapi_name() === 'cli') {
            $routeInfos = $router->getRouteInfosFromArgv();
        }  else {
            $routeInfos = $router->getRouteInfosFromURI();
        }
        self::_executeRoute($routeInfos);
    }
    
    
    /**
     * Execute route 
     * 
     * @param array $routeInfos
     */
    protected static function _executeRoute($routeInfos) 
    {
        $class = '\App\\' . $routeInfos['app'] . 
                 '\\Controller\\' . $routeInfos['controller'];
        
        $controller = new $class();
        
        return call_user_func_array(array($controller, $routeInfos['method']), $routeInfos['argv']);
    }
}

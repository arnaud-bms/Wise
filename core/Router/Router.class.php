<?php
namespace Tlc\Router;

use Tlc\Component\Component;
use Tlc\Router\RouterException;
use Tlc\Conf\Conf;

/**
 * Router extract informations from route
 *
 * @author gdievart
 */
class Router extends Component 
{
    
    /**
     * @var type current sapi_name
     */
    private $_sapiName = null;
    
    
    /**
     * Init Router
     * 
     * @param array $config
     */
    protected function _init($config)
    {
        $this->_sapiName = php_sapi_name();
    }
    
    
    /**
     * Extract route informatios from argv
     * 
     * @return array 
     */
    public function getRouteInfos()
    {
        if($this->_sapiName === 'cli') {
            array_shift($_SERVER['argv']);
            $route = implode($_SERVER['argv'], ' ');
        }  else {
            $route = $_SERVER['REQUEST_URI'];
        }
        
        return $this->_getRouteInfos($route);
    }
    
    
    /**
     * Extract informations from route
     * 
     * @param string $route
     * @return array
     */
    private function _getRouteInfos($route)
    {
        $routeInfos = false;
        $routing = $this->_getRoutingApp($route);
        foreach($routing['routing'] as $routeName => $routeTest) {
            $pattern = '#' . $routeTest['pattern'] . '#';
            if(preg_match($pattern, $route, $argv )) {
                $routeInfos = $routeTest;
                array_shift($argv);
                $routeInfos['argv'] = $argv;
                $routeInfos['name'] = $routing['name'] . ':' . $routeName;
                break;
            }
        }
        
        if($routeInfos === false) {
            throw new RouterException("Route '$route' not matches", 404);
        }
        
        return $routeInfos;
    }
    
    
    /**
     * Extract informations from main routing
     * 
     * @param string $route
     * @return array
     */
    private function _getRoutingApp($route)
    {
        $routing = false;
        foreach(Conf::getConfig('route') as $routingName => $routingInfos) {
            $prefix = substr($route, 0, strlen($routingInfos['prefix']));
            if($routingInfos['type'] === $this->_sapiName && $routingInfos['prefix'] === $prefix) {
                $routing['name'] = $routingName;
                $routing['routing'] = parse_ini_file($routingInfos['routing'], true);
                break;
            }
        }
        
        if($routing === false) {
            throw new RouterException("Route '$route' not matches", 404);
        }
        
        return $routing;
    }
}

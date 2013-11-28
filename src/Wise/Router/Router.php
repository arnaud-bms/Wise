<?php
namespace Wise\Router;

use Wise\Component\Component;

/**
 * class \Wise\Router\Router
 * 
 * This class is use to extract the routes args (plugins, controller)
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Router extends Component
{
    /**
     * @staticvar SAPI
     */
    const SAPI_CLI = 'cli';
    const SAPI_CGI = 'cgi';

    /**
     * The current sapi
     * 
     * @var string
     */
    private $sapiName;
    
    /**
     * Default values
     *
     * @var array
     */
    private $default = array();
    
    /**
     * Routes
     *
     * @var array
     */
    private $routes = array();

    /**
     * {@inherit}
     */
    protected function init($config)
    {
        $this->sapiName = php_sapi_name();
        $this->default  = !empty($config['default']) ? $config['default'] : array();
        if(!empty($config['routes'])) {
            $this->loadRoutes($config['routes']);
        }
    }
    
    /**
     * Load the routes from the config
     * 
     * @param array $routes
     * @return array the routes informations
     */
    protected function loadRoutes($routes)
    {
        foreach ($routes as $name => $route) {
            $this->addRoute($name, $route);
        }
    }
    
    /**
     * Add a route
     * 
     * @param string $name
     * @param array  $route The route informations
     * @throws Exception
     */
    public function addRoute($name, $route)
    {
        if (!array_key_exists('pattern', $route)) {
            throw new Exception('The field "pattern" is missed for the route "'.$name.'"', 0);
        }

        $defaultValues = array();
        if (false !== strpos($name, '@')) {
            list($app, $routeName) = explode('@', $name);
            $defaultValues = !empty($this->default[$app]) ? $this->default[$app] : array();
        }

        $this->routes[$name] = array_merge($defaultValues, $route);
    }
    
    /**
     * Extract the route informations from argv
     *
     * @param  string $route
     * @return array The route informations
     */
    public function getRoute($route = null)
    {
        if ($route === null) {
            if ($this->sapiName === self::SAPI_CLI) {
                array_shift($_SERVER['argv']);
                $route = implode($_SERVER['argv'], ' ');
            } else {
                $route = $_SERVER['SCRIPT_NAME'];
            }
        }
        
        return $this->getRouteInfos($route);
    }
    
    /**
     * Delete a route from the router
     * 
     * @param string $name Te route name
     */
    public function deleteRoute($name)
    {
        if (!array_key_exists($name, $this->routes)) {
            throw new Exception('The route "'.$name.'" does not exist', 0);
        }
        
        unset($this->routes[$name]);
    }

    /**
     * Extract informations from route
     *
     * @param  string $route
     * @return array
     */
    private function getRouteInfos($route)
    {
        $routeInfos = false;
        foreach ($this->routes as $routeName => $routeRules) {
            if (preg_match('/^'.str_replace('/', '\/', $routeRules['pattern']).'$/', $route, $argv)) {
                if ($this->isRightRules($routeRules)) {
                    $routeInfos = $routeRules;
                    array_shift($argv);
                    $routeInfos['argv'] = $argv;
                    $routeInfos['name'] = $routeName;
                    break;
                }
            }
        }

        if ($routeInfos === false) {
            throw new Exception('The route "'.$route.'" not matches', 0);
        }

        return $routeInfos;
    }
    
    /**
     * Check the route rules
     */
    protected function isRightRules($routeRules)
    {
        list($host, $method) = $this->getServerInfos();
        
        if (!empty($routeRules['sapi']) && $this->sapiName !== $routeRules['sapi']) {
            return false;
        }
        
        if (!empty($routeRules['method']) && $method !== \Wise\String\String::lower($routeRules['method'])) {
            return false;
        }
        
        if (!empty($routeRules['host'])) {
            $hostPattern = str_replace('\*', '.+', preg_quote($routeRules['host'], '/'));
            if (!preg_match('/^'.$hostPattern.'$/', $routeRules['host'])) {
                return false;
            }
        }
                
        return true;
    }
    
    /**
     * Retrieve the server informations
     * 
     * @return array
     */
    protected function getServerInfos()
    {
        $host   = !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
        $method = !empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';
        
        return array($host, $method);
    }
}

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
    protected $requiredFieldsRoute = array(
        'routes'
    );

    /**
     * {@inherit}
     */
    protected function init($config)
    {
        $this->sapiName = php_sapi_name();
        $this->default  = !empty($config['default']) ? $config['default'] : array();
        $this->routes   = $this->loadRoutes($config['routes']);
    }
    
    /**
     * Load the routes from the config
     * 
     * @param array $routes
     * @return array the routes informations
     */
    protected function loadRoutes($routes)
    {
        $routesLoaded = array();
        foreach ($routes as $routeName => $infos) {
            if (!array_key_exists('pattern', $infos)) {
                throw new Exception('The field "pattern" is missed for the route "'.$routeName.'"', 0);
            }
            
            if (false !== strpos($routeName, '.')) {
                list($app, $route) = explode('.', $routeName);
                $defaultValues = !empty($this->default[$app]) ? $this->default[$app] : array();
            }
            
            $routesLoaded[$routeName] = array_merge($defaultValues, $infos);
        }
        
        return $routesLoaded;
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
                $route = $_SERVER['REQUEST_URI'];
            }
        }

        return $this->getRouteInfos($route);
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

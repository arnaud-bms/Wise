<?php
namespace Telelab\Router;

use Telelab\Component\Component;
use Telelab\Router\RouterException;
use Telelab\Conf\Conf;
use Telelab\Logger\Logger;

/**
 * Router extract informations from route
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
     * @var string current sapi_name
     */
    private $sapiName = null;

    /**
     * @var string Name of route app loaded
     */
    protected static $routeAppLoaded = null;

    /**
     * @var array Required fields to route app
     */
    private $requiredFieldsRouteApp = array(
        'prefix',
        'app'
    );

    /**
     * @var array Required fields to route
     */
    private $requiredFieldsRoute = array(
        'pattern'
    );

    /**
     * @var Cache
     */
    private $cache;


    /**
     * Init Router
     *
     * @param array $config
     */
    protected function init($config)
    {
        $this->sapiName = php_sapi_name();
        $this->setRouteAppLoaded(null);
        $this->initCache();
        Logger::log('['.__CLASS__.'] call by sapi -> '.$this->sapiName, Logger::LOG_DEBUG);
    }


    /**
     * Init cache system if the section routercache exist
     */
    private function initCache()
    {
        if ($this->cache === null && $routerConf = Conf::getConfig('routercache')) {
            $this->cache = new \Telelab\Cache\Cache($routerConf);
        }
    }


    /**
     * Get route app name
     */
    public static function getRouteAppLoaded()
    {
        return self::$routeAppLoaded;
    }


    /**
     * Set route app loaded
     *
     * @param string $routeName
     */
    public static function setRouteAppLoaded($routeName)
    {
        self::$routeAppLoaded = $routeName;
    }


    /**
     * Extract route informatios from argv
     *
     * @param string $route
     * @return array
     */
    public function getRouteInfos($route = null)
    {
        if ($route === null) {
            if ($this->sapiName === self::SAPI_CLI) {
                array_shift($_SERVER['argv']);
                $route = implode($_SERVER['argv'], ' ');
            } else {
                $route = $_SERVER['REQUEST_URI'];
            }
        }

        Logger::log('['.__CLASS__.'] route -> '.$route, Logger::LOG_DEBUG);

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
        $routing = $this->getRoutingApp($route);
        $httpMethod = !empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';

        $cacheId = 'telelab:router:'.md5($route.$httpMethod);
        if ($this->cache !== null && $routeInfos = $this->cache->getCache($cacheId)) {
            Logger::log('['.__CLASS__.'] route from cache -> '.$route, Logger::LOG_DEBUG);
            return $routeInfos;
        } else {
            foreach ($routing as $routeName => $routeTest) {
                $this->checkFieldsRoute($routeTest);
                $pattern = '#^'.$routeTest['pattern'].'$#';
                Logger::log('['.__CLASS__.'] test route -> '.$routeName, Logger::LOG_DEBUG);
                if (preg_match($pattern, $route, $argv)
                    && (empty($routeTest['http_method'])
                        || strtolower($routeTest['http_method']) === strtolower($httpMethod))
                ) {
                    Logger::log('['.__CLASS__.'] route matches -> '.$routeName, Logger::LOG_DEBUG);
                    $routeInfos = $routeTest;
                    array_shift($argv);
                    $routeInfos['argv'] = $argv;
                    $routeInfos['name'] = $this->getRouteAppLoaded().':'.$routeName;
                    Logger::log('['.__CLASS__.'] route loaded -> '.$this->getRouteAppLoaded().':'.$routeName, Logger::LOG_DEBUG);
                    break;
                } else {
                    Logger::log('['.__CLASS__.'] route no matches -> '.$routeName, Logger::LOG_DEBUG);
                }
            }
        }

        if ($routeInfos === false) {
            throw new RouterException("Route '$route' not matches", 404);
        }

        if ($this->cache !== null) {
            $this->cache->setCache($cacheId, $routeInfos);
        }

        return $routeInfos;
    }


    /**
     * Check require fields for routeApp
     *
     * @param array $routeApp
     */
    private function checkFieldsRoute($route)
    {
        foreach ($this->requiredFieldsRoute as $field) {
            if (!array_key_exists($field, $route)) {
                throw new RouterException("The field '$field' is required in route", 407);
            }
        }
    }


    /**
     * Extract informations from main routing
     *
     * @param string $route
     * @return array
     */
    private function getRoutingApp($route)
    {
        $routing = false;
        if ($routeConfig = Conf::getConfig('route_apps')) {
            foreach ($routeConfig as $routeName => $routeApp) {
                $this->checkFieldsRouteApp($routeApp);

                $matchPrefix   = preg_match('/^'.$routeApp['prefix'].'/', $route);
                $hostname      = !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
                $matchHostname = (empty($routeApp['host_pattern']) && empty($routeApp['host'])) || $this->sapiName === self::SAPI_CLI || (!empty($routeApp['host']) && ($routeApp['host'] === $hostname)) || (!empty($routeApp['host_pattern']) && preg_match('/^'.$routeApp['host_pattern'].'$/', $hostname));
                $matchType     = empty($routeApp['type']) || $routeApp['type'] === $this->sapiName;
                
                Logger::log('['.__CLASS__.'] test route app -> '.$routeName, Logger::LOG_DEBUG);
                if ($matchType && $matchHostname && $matchPrefix) {
                    Logger::log('['.__CLASS__.'] route matches -> '.$routeName, Logger::LOG_DEBUG);
                    $this->loadApp($routeApp);
                    $routing = Conf::getConfig('routing');
                    $this->setRouteAppLoaded($routeName);
                    break;
                } else {
                    Logger::log('['.__CLASS__.'] route no matches -> '.$routeName, Logger::LOG_DEBUG);
                }
            }
        } else {
            Logger::log('['.__CLASS__.'] no routing app find', Logger::LOG_DEBUG);
        }

        if ($routing === false) {
            throw new RouterException("Route app '$route' not matches", 404);
        }

        return $routing;
    }


    /**
     * Check require fields for routeApp
     *
     * @param array $routeApp
     */
    private function checkFieldsRouteApp($routeApp)
    {
        foreach ($this->requiredFieldsRouteApp as $field) {
            if (!array_key_exists($field, $routeApp)) {
                throw new RouterException("The field '$field' is required in routeApp", 406);
            }
        }
    }


    /**
     * Load bootstrap application
     *
     * @param array $routeApp
     */
    private function loadApp($routeApp)
    {
        Logger::log('['.__CLASS__.'] load app -> '.$routeApp['app'], Logger::LOG_DEBUG);

        if (isset($routeApp['path'])) {
            $bootstrapFile = $routeApp['path'].'/bootstrap.php';
        } else {
            $bootstrapFile = ROOT_DIR.'app/'.$routeApp['app'].'/bootstrap.php';
        }

        if (file_exists($bootstrapFile)) {
            require $bootstrapFile;
        } else {
            throw new RouterException("Require bootstrap.php for '{$routeApp['app']}' application", 410);
        }
    }
}

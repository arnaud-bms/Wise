<?php
namespace Wise\Router;

use Wise\Component\Component;
use Wise\Router\RouterException;
use Wise\Conf\Conf;

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
     * @param  string $route
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

        return $this->_getRouteInfos($route);
    }

    /**
     * Extract informations from route
     *
     * @param  string $route
     * @return array
     */
    private function _getRouteInfos($route)
    {
        $routeInfos = false;
        $routing = $this->getRoutingApp($route);
        $httpMethod = !empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';

        $cacheId = 'wise:router:'.md5($route.$httpMethod);
        if ($this->cache !== null && $routeInfos = $this->cache->getCache($cacheId)) {

            return $routeInfos;
        } else {
            foreach ($routing as $routeName => $routeTest) {
                $this->checkFieldsRoute($routeTest);
                $pattern = '#^'.$routeTest['pattern'].'$#';
                if (preg_match($pattern, $route, $argv)
                    && (empty($routeTest['http_method'])
                        || strtolower($routeTest['http_method']) === strtolower($httpMethod))
                ) {
                    $routeInfos = $routeTest;
                    array_shift($argv);
                    $routeInfos['argv'] = $argv;
                    $routeInfos['name'] = $this->getRouteAppLoaded().':'.$routeName;
                    break;
                }
            }
        }

        if ($routeInfos === false) {
            throw new RouterException("Route '$route' not matches", 404);
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
     * @param  string $route
     * @return array
     */
    private function getRoutingApp($route)
    {
        $routing = false;
        if ($routeConfig = Conf::get('route_apps')) {
            foreach ($routeConfig as $routeName => $routeApp) {
                $this->checkFieldsRouteApp($routeApp);

                $matchPrefix   = preg_match('/^'.preg_quote($routeApp['prefix'], '/').'/', $route);
                $hostname      = !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
                $matchHostname = (empty($routeApp['host_pattern']) && empty($routeApp['host'])) || $this->sapiName === self::SAPI_CLI || (!empty($routeApp['host']) && ($routeApp['host'] === $hostname)) || (!empty($routeApp['host_pattern']) && preg_match('/^'.$routeApp['host_pattern'].'$/', $hostname));
                $matchType     = empty($routeApp['type']) || $routeApp['type'] === $this->sapiName;

                if ($matchType && $matchHostname && $matchPrefix) {
                    $this->loadApp($routeApp);
                    $routing = Conf::get('routing');
                    $this->setRouteAppLoaded($routeName);
                    break;
                }
            }
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

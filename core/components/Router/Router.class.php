<?php
namespace Telco\Router;

use Telco\Component\Component;
use Telco\Router\RouterException;
use Telco\Conf\Conf;

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
    private $_sapiName = null;

    /**
     * @var string Name of route app loaded
     */
    private $_routeAppLoaded = null;

    /**
     * @var array Required fields to route app
     */
    private $_requiredFieldsRouteApp = array(
        'type',
        'prefix',
        'app'
    );

    /**
     * @var array Required fields to route
     */
    private $_requiredFieldsRoute = array(
        'pattern',
        'controller',
        'method'
    );


    /**
     * Init Router
     *
     * @param array $config
     */
    protected function _init($config)
    {
        $this->_sapiName       = php_sapi_name();
        $this->_routeAppLoaded = null;
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
            if ($this->_sapiName === self::SAPI_CLI) {
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
     * @param string $route
     * @return array
     */
    private function _getRouteInfos($route)
    {
        $routeInfos = false;
        $routing = $this->_getRoutingApp($route);
        foreach ($routing as $routeName => $routeTest) {
            $this->_checkFieldsRoute($routeTest);
            $pattern = '#'.$routeTest['pattern'].'#';
            if (preg_match($pattern, $route, $argv)) {
                $routeInfos = $routeTest;
                array_shift($argv);
                $routeInfos['argv'] = $argv;
                $routeInfos['name'] = $this->_routeAppLoaded.':'.$routeName;
                break;
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
    private function _checkFieldsRoute($route)
    {
        foreach ($this->_requiredFieldsRoute as $field) {
            if (!array_key_exists($field, $route)) {
                throw new RouterException(
                    "The field '$field' is required in route", 407
                );
            }
        }
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
        if ($routeConfig = Conf::getConfig('route_apps')) {
            foreach ($routeConfig as $routeName => $routeApp) {
                $this->_checkFieldsRouteApp($routeApp);
                $prefix = substr($route, 0, strlen($routeApp['prefix']));
                if (strtolower($routeApp['type']) === $this->_sapiName
                    && $routeApp['prefix'] === $prefix
                ) {
                    $this->_loadApp($routeApp['app']);
                    $routing = Conf::getConfig('routing');
                    $this->_routeAppLoaded = $routeName;
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
    private function _checkFieldsRouteApp($routeApp)
    {
        foreach ($this->_requiredFieldsRouteApp as $field) {
            if (!array_key_exists($field, $routeApp)) {
                throw new RouterException(
                    "The field '$field' is required in routeApp", 406
                );
            }
        }
    }


    /**
     * Load bootstrap application
     *
     * @param string $appName
     */
    private function _loadApp($appName)
    {
        $bootstrapFile = ROOT_DIR.'app/'.$appName.'/bootstrap.php';
        if (file_exists($bootstrapFile)) {
            require_once $bootstrapFile;
        } else {
            throw new RouterException(
                "Require bootstrap.php for '$appName' application", 410
            );
        }
    }
}

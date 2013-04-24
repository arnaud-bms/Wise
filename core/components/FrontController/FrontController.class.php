<?php
namespace Telelab\FrontController;

use Telelab\Component\ComponentStatic;
use Telelab\Router\Router;
use Telelab\Conf\Conf;
use Telelab\Logger\Logger;

/**
 * FrontController: Load route application, execute plugin and controller
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class FrontController extends ComponentStatic
{
    /**
     * @staticvar string Method name call on plugins
     */
    const PLUGIN_PRECALL = 'precall';
    const PLUGIN_POSTCALL = 'postcall';

    /**
     * @var string Uniq id generate by route informations
     */
    protected static $_routeId;

    /**
     * @var string Route name
     */
    protected static $_routeName;

    /**
     * @var string Pattern matches
     */
    protected static $_pattern;

    /**
     * @var string Controller class name
     */
    protected static $_controller;

    /**
     * @var string Method call on controller
     */
    protected static $_method;

    /**
     * @var array Args to pass to controller
     */
    protected static $_argv = array();

    /**
     * @var array Plugins call
     */
    protected static $_plugins = array();

    /**
     * @var array Ref to plugin loaded
     */
    protected static $_pluginsLoaded = array();

    /**
     * @var boolean Interrupt request
     */
    protected static $_interrupRequest = false;

    /**
     * @var string Response
     */
    protected static $_response;

    /**
     * Run application
     */
    public static function run($route = null)
    {
        self::_setRouteInfos(self::_getRouteInfos($route));
        self::_executeRoute();
    }


    /**
     * Get routes informations from Router
     *
     * @param string $route
     * @return array
     */
    private static function _getRouteInfos($route)
    {
        try {
            $router = new Router();
            $routeInfos = $router->getRouteInfos($route);
        } catch (\Telelab\Router\RouterException $e) {
            header("HTTP/1.1 404 Not found");
            if ($error = Conf::getConfig('route_error.404')) {
                self::run($error);
            }
            exit(0);
        }

        return $routeInfos;
    }


    /**
     * Set informations from routeInfos
     *
     * @param array $routeInfos
     */
    protected static function _setRouteInfos($routeInfos)
    {
        self::$_routeId    = md5(serialize($routeInfos));
        self::$_routeName  = $routeInfos['name'];
        self::$_pattern    = $routeInfos['pattern'];
        self::$_argv       = $routeInfos['argv'];

        if (isset($routeInfos['controller'])) {
            if (strpos($routeInfos['controller'], '::') !== false) {
                list(self::$_controller, self::$_method) = explode('::', $routeInfos['controller']);
            } else {
                self::$_controller = $routeInfos['controller'];
                self::$_method     = $routeInfos['method'];
            }
        }

        if (isset($routeInfos['precall'])) {
            self::$_plugins[self::PLUGIN_PRECALL] = explode(';', $routeInfos['precall']);
        } elseif ($precall = Conf::getConfig('plugin.default_precall')) {
            self::$_plugins[self::PLUGIN_PRECALL] = explode(';', $precall);
        } else {
            self::$_plugins[self::PLUGIN_PRECALL] = array();
        }

        if (isset($routeInfos['postcall'])) {
            self::$_plugins[self::PLUGIN_POSTCALL] = explode(';', $routeInfos['postcall']);
        } elseif ($precall = Conf::getConfig('plugin.default_postcall')) {
            self::$_plugins[self::PLUGIN_POSTCALL] = explode(';', $precall);
        } else {
            self::$_plugins[self::PLUGIN_POSTCALL] = array();
        }
    }


    /**
     * Execute route
     */
    protected static function _executeRoute()
    {
        self::_executePlugins(self::PLUGIN_PRECALL);
        self::_executeAction();
        self::_executePlugins(self::PLUGIN_POSTCALL);
    }


    /**
     * Execute plugins
     *
     * @param string $type
     */
    protected static function _executePlugins($method)
    {
        Logger::log('['.__CLASS__.'] excute '.$method.' plugins', Logger::LOG_DEBUG);
        if (!self::$_interrupRequest) {
            foreach (self::$_plugins[$method] as $plugin) {
                if (empty($plugin)) {
                    continue;
                }
                
                if (!isset(self::$_pluginsLoaded[$plugin])) {
                    self::$_pluginsLoaded[$plugin] = new $plugin();
                }

                if ($method === self::PLUGIN_PRECALL) {
                    self::$_pluginsLoaded[$plugin]->precall();
                } else {
                    self::$_pluginsLoaded[$plugin]->postCall();
                }

                Logger::log('['.__CLASS__.'] excute plugin -> '.$plugin, Logger::LOG_DEBUG);

                if (self::$_interrupRequest) {
                    Logger::log('['.__CLASS__.'] interrup request', Logger::LOG_DEBUG);
                    break;
                }
            }
        }
    }


    /**
     * Execute controller
     */
    protected static function _executeAction()
    {
        if (!self::$_interrupRequest && self::$_controller !== null) {
            Logger::log(
                '['.__CLASS__.'] excute action -> '
                .self::$_controller.'::'.self::$_method.'('.implode(',', self::$_argv).')',
                Logger::LOG_DEBUG
            );

            $controller = new self::$_controller();
            self::$_response = call_user_func_array(
                array($controller, self::$_method),
                self::$_argv
            );
        } else {
            self::$_response = array();
        }
    }


    /**
     * Interrupt request and return response
     */
    public static function interruptRequest()
    {
        self::$_interrupRequest = true;
    }


    /**
     * Retrieve route id
     *
     * @return string
     */
    public static function getRouteId()
    {
        return self::$_routeId;
    }


    /**
     * Retrieve route name
     *
     * @return string
     */
    public static function getRouteName()
    {
        return self::$_routeName;
    }


    /**
     * Retrieve response
     *
     * @return mixed
     */
    public static function getResponse()
    {
        return self::$_response;
    }


    /**
     * Set response
     *
     * @param mixed $response
     */
    public static function setResponse($response)
    {
        self::$_response = $response;
    }
}

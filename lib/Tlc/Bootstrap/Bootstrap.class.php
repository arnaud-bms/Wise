<?php
namespace Tlc\Bootstrap;

use Tlc\Component\Component;
use Tlc\Router\Router;

/**
 * Description of Bootstrap
 *
 * @author gdievart
 */
class Bootstrap extends Component 
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
    public static function run() 
    {
        $router = new Router();
        self::_setRouteInfos($router->getRouteInfos());
        self::_executeRoute();
    }
    
    
    /**
     * Set informations from routeInfos
     * 
     * @param array $routeInfos 
     */
    protected static function _setRouteInfos($routeInfos)
    {
        self::$_routeId = md5(serialize($routeInfos));
        self::$_routeName = $routeInfos['name'];
        self::$_pattern = $routeInfos['pattern'];
        self::$_controller = $routeInfos['controller'];
        self::$_method = $routeInfos['method'];
        self::$_argv = $routeInfos['argv'];
        self::$_plugins[self::PLUGIN_PRECALL] = isset($routeInfos['precall']) ? $routeInfos['precall'] : array();
        self::$_plugins[self::PLUGIN_POSTCALL] = isset($routeInfos['postcall']) ? $routeInfos['postcall'] : array();
    }
    
    
    /**
     * Execute route 
     * 
     * @param array $routeInfos
     */
    protected static function _executeRoute() 
    {
        self::_executePlugins(self::PLUGIN_PRECALL);
        self::_executeAction();
        self::_executePlugins(self::PLUGIN_POSTCALL);
        
        return self::$_response;
    }
    
    
    /**
     * Execute plugins
     * 
     * @param string $type
     */
    protected static function _executePlugins($method)
    {
        if(!self::$_interrupRequest) {
            foreach(self::$_plugins[$method] as $plugin) {
                if(!isset(self::$_pluginsLoaded[$plugin])) {
                    self::$_pluginsLoaded[$plugin] = new $plugin();
                }

                self::$_pluginsLoaded[$plugin]->$method();

                if(self::$_interrupRequest) {
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
        if(!self::$_interrupRequest) {
            $controller = new self::$_controller();
            self::$_response = call_user_func_array(array(
                                    $controller, 
                                    self::$_method), 
                                    self::$_argv);
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
        return self::getRouteId();
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
     * @return string
     */
    public static function setResponse($reponse)
    {
        self::$_response = $response;
    }
}

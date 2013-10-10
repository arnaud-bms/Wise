<?php
namespace Plugin;

use Telelab\Plugin\Plugin;
use Telelab\Conf\Conf;
use Telelab\FrontController\FrontController;
use Telelab\Globals\Globals;

/**
 * Plugin Firewall: This method is called for check if the user is authorized
 * to show current page
 *
 * @author gdievart
 */
class Firewall extends Plugin
{

    /**
     * Init Plugin Cache
     */
    public function _init($config)
    {

    }

    /**
     * Check if the current user is connected and if the current route is protected
     */
    public function precall()
    {
        if (!Globals::get('is_connected')) {
            $this->_checkRoute();
        }
    }


    /**
     * Redirect if the route is protected
     *
     * @param string $config
     */
    protected function _checkRoute($config = 'firewall')
    {
        if ($this->_isProtectedRoute($config)) {
            if (Conf::getConfig($config.'.redirect_type') == 'bg') {
                FrontController::run(Conf::getConfig($config.'.redirect'));
                FrontController::interruptRequest();
            } else {
                header('Location: '.Conf::getConfig($config.'.redirect'));
                exit(0);
            }
        }
    }


    /**
     * Check if the route is protected
     *
     * @return boolean
     */
    private function _isProtectedRoute($config)
    {
        list($module, $route) = explode(':', FrontController::getRouteName());
        $routes = Conf::getConfig($config.'.route');
        $isProtected = false;

        foreach ($routes as $routeProtected) {
            if ($patternPos = strpos($routeProtected, '*')) {
                if (substr($route, 0, $patternPos) === substr($routeProtected, 0, $patternPos)) {
                    $isProtected = true;
                    break;
                }
            } elseif ($route === $routeProtected) {
                $isProtected = true;
                break;
            }
        }

        return $isProtected;
    }


    /**
     * Nothing !
     */
    public function postcall()
    {

    }
}
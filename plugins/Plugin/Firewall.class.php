<?php
namespace Plugin;

use Telelab\Plugin\Plugin;
use Telelab\Conf\Conf;
use Telelab\FrontController\FrontController;
use Telelab\Globals\Globals;

/**
 * Plugin Cache, use Telelab\Cache
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
     * Method call on precall
     */
    public function precall()
    {
        if ($this->_isProtectedRoute()) {
            if (!Globals::get('is_connected')) {
                if (Conf::getConfig('firewall.redirect_type') == 'bg') {
                    FrontController::run(Conf::getConfig('firewall.redirect'));
                    FrontController::interruptRequest();
                } else {
                    header('Location: '.Conf::getConfig('firewall.redirect'));
                    exit(0);
                }
            }
        }
    }


    /**
     * Check if the route is protected
     *
     * @return boolean
     */
    protected function _isProtectedRoute()
    {
        list($module, $route) = explode(':', FrontController::getRouteName());
        $routes = Conf::getConfig('firewall.route');
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
     * Method call on precall
     */
    public function postcall()
    {

    }
}

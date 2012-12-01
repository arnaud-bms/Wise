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
        list($module, $route) = explode(':', FrontController::getRouteName());
        $routes = Conf::getConfig('firewall.route');

        if(in_array($route, $routes)) {
            if(!Globals::get('is_connected')) {
                if(Conf::getConfig('firewall.redirect_type') == 'bg') {
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
     * Method call on precall
     */
    public function postcall()
    {

    }
}

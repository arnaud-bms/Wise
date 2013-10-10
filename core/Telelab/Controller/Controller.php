<?php
namespace Telelab\Controller;

use Telelab\FrontController\FrontController;
use Telelab\Component\Component;
use Telelab\Server\Server;

/**
 * Controller: Base class for controller
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
abstract class Controller extends Component
{

    /**
     * @var array Repository loaded
     */
    protected $_repositoryLoaded = array();

    /**
     * @var Server instance
     */
    private static $_server = null;


    /**
     * Init Controller
     *
     * @param array $config
     */
    protected function _init($config)
    {
        self::$_server = new Server();
    }

    /**
     * Redirect
     *
     * @param string $route
     */
    protected function _redirect($route)
    {
        FrontController::run($route);
        FrontController::interruptRequest();
    }


    /**
     * Get ref to repository
     *
     * @param string $repository
     * @return Repository
     */
    public function getRepository($repository)
    {
        if (!isset($this->_repositoryLoaded[$repository])) {
            $this->_repositoryLoaded[$repository] = new $repository();
        }

        return $this->_repositoryLoaded[$repository];
    }


    /**
     * Call method on server
     *
     * @param string $method
     * @param array $argv
     * @return mixed
     */
    public function __call($method, $argv)
    {
        if (method_exists(self::$_server, $method)) {
            return call_user_func_array(array(self::$_server, $method), $argv);
        }

        return null;
    }
}

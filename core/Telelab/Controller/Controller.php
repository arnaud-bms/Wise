<?php
namespace Telelab\Controller;

use Telelab\FrontController\FrontController;
use Telelab\Component\Component;
use Telelab\Server\Server;

/**
 * Controller: Base class for controller
 *
 * @author gdievart <dievartg@gmail.com>
 */
abstract class Controller extends Component
{

    /**
     * @var array Repository loaded
     */
    protected $repositoryLoaded = array();

    /**
     * @var Server instance
     */
    private static $server = null;

    /**
     * Init Controller
     *
     * @param array $config
     */
    protected function initAuto($config)
    {
        self::$server = new Server();

        parent::initAuto($config);
    }

    /**
     * Redirect
     *
     * @param string $route
     */
    protected function redirect($route)
    {
        FrontController::run($route);
        FrontController::interruptRequest();
    }

    /**
     * Get ref to repository
     *
     * @param  string     $repository
     * @return Repository
     */
    public function getRepository($repository)
    {
        if (!isset($this->repositoryLoaded[$repository])) {
            $this->repositoryLoaded[$repository] = new $repository();
        }

        return $this->repositoryLoaded[$repository];
    }

    /**
     * Call method on server
     *
     * @param  string $method
     * @param  array  $argv
     * @return mixed
     */
    public function __call($method, $argv)
    {
        if (method_exists(self::$server, $method)) {
            return call_user_func_array(array(self::$server, $method), $argv);
        }

        return null;
    }
}

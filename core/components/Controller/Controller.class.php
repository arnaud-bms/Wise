<?php
namespace Telelab\Controller;

use Telelab\FrontController\FrontController;
use Telelab\Component\Component;

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
}

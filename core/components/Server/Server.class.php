<?php
namespace Telelab\Server;

use Telelab\Component\Component;

/**
 * Server: browser kit and server parameters
 *
 * @author fmanas <f.manas@telemaque.fr>
 */
class Server extends Component
{

    /**
     * @var array server parameters
     */
    protected $_parameters;

    /**
     * @var array server parameters
     */
    protected $_requestMethods = array(
        'post' => array(),
        'get'  => array(),
        'head' => array()
    );


    /**
     * @var string current request methods
     */
    protected $_requestMethod = '';


    /**
     * Init View
     *
     * @param array $config
     */
    protected function _init($config)
    {
        $this->_requestMethod = $_SERVER['REQUEST_METHOD'];

        $this->_parameters = $_REQUEST;
    }


    /**
     * retrieve parameter
     *
     * @param string $key
     */
    public function getParameter($key)
    {
        if (array_key_exists($key, $this->_parameters)) {
            return $this->_parameters[$key];
        }

        return null;
    }


    /**
     * retrieve parameters
     */
    public function getParameters()
    {
        return $this->_parameters;
    }
}
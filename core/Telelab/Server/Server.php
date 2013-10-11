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
    protected $parameters;

    /**
     * @var array server parameters
     */
    protected $requestMethods = array(
        'post' => array(),
        'get'  => array(),
        'head' => array()
    );


    /**
     * @var string current request methods
     */
    protected $requestMethod = '';


    /**
     * Init View
     *
     * @param array $config
     */
    protected function _init($config)
    {
        $this->requestMethod = !empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';

        $this->parameters = $_REQUEST;
    }


    /**
     * retrieve parameter
     *
     * @param string $key
     */
    public function getParameter($key)
    {
        if (array_key_exists($key, $this->parameters)) {
            return $this->parameters[$key];
        }

        return null;
    }


    /**
     * retrieve parameters
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
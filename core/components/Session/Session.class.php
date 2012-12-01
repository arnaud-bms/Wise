<?php
namespace Telelab\Session;

use Telelab\Component\Component;

/**
 * Manage session
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class Session extends Component
{

    /**
     * Start session
     */
    protected function _init($config)
    {
        session_start();
    }


    /**
     * Set cookie params
     *
     * @param int $lifeTime
     * @param string $path
     * @param string $domain
     * @param boolean $secure
     * @param boolean $httpOnly
     */
    public function setCookieParams(
            $lifeTime, $path = null, $domain = null,
            $secure = false, $httpOnly = false)
    {
        session_set_cookie_params($lifeTime, $path, $domain, $secure, $httpOnly);
    }


    /**
     * Destroy session
     */
    public function destroy()
    {
        $_SESSION = array();
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 10,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
        session_destroy();
    }


    /**
     * Set arg to $_SESSION
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }


    /**
     * Get arg from $_SESSION
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if(array_key_exists($name, $_SESSION)) {
            return $_SESSION[$name];
        }
    }
}
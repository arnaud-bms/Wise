<?php
namespace Telelab\Globals;

use Telelab\Component\ComponentStatic;

/**
 * Global is used for pass var from plugin to controller
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class Globals extends ComponentStatic
{

    /**
     * @var array list params
     */
    private static $_params = array();


    /**
     * Init Globals component
     *
     * @param array $config
     */
    protected static function _init($config)
    {
        foreach ($config as $name => $value) {
            self::set($name, $value);
        }
    }


    /**
     * Set arg to _params
     *
     * @param string $name
     * @param mixed $value
     */
    public static function set($name, $value)
    {
        self::$_params[$name] = $value;
    }


    /**
     * Get arg from $_SESSION
     *
     * @param string $name
     * @return mixed
     */
    public static function get($name)
    {
        if (array_key_exists($name, self::$_params)) {
            return self::$_params[$name];
        }
    }
}

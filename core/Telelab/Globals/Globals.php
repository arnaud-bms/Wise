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
    private static $params = array();


    /**
     * Init Globals component
     *
     * @param array $config
     */
    protected static function _init($config)
    {
        if (is_array($config)) {
            foreach ($config as $name => $value) {
                self::set($name, $value);
            }
        }
    }


    /**
     * Set arg to params
     *
     * @param string $name
     * @param mixed $value
     */
    public static function set($name, $value)
    {
        self::$params[$name] = $value;
    }


    /**
     * Get arg from $_SESSION
     *
     * @param string $name
     * @return mixed
     */
    public static function get($name)
    {
        if (array_key_exists($name, self::$params)) {
            return self::$params[$name];
        }
    }
}

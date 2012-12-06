<?php
namespace Telelab\Autoloader;

/**
 * Autoloader: Include class file
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class Autoloader
{
    /**
     * @var array List alias
     */
    private static $_alias = array();

    /**
     * Register autoload
     *
     * @return type
     */
    public static function loadClass($class)
    {
        list($alias) = explode('\\', $class);
        foreach (self::$_alias as $prefix => $path) {
            if ($alias === $prefix) {
                $class = substr($class, strlen($prefix)+1);
                if (file_exists($path.'/'.strtr($class, '\\', '/').'.class.php')) {
                    require $path.'/'.strtr($class, '\\', '/').'.class.php';
                }
                break;
            }
        }
    }


    /**
     * Set alias
     *
     * @param array $alias
     */
    public static function setAlias($alias)
    {
        self::$_alias = $alias;
    }


    /**
     * Add alias
     *
     * @param array $alias
     */
    public static function addAlias($alias)
    {
        self::$_alias = array_merge(self::$_alias, $alias);
    }
}

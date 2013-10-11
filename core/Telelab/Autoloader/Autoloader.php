<?php
namespace Telelab\Autoloader;

use Telelab\Autoloader\AutoloaderException;

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
    private static $alias = array();

    /**
     * Register autoload
     *
     * @throws AutoloaderException If file class does'nt exists
     * @return type
     */
    public static function loadClass($class)
    {
        list($alias) = explode('\\', $class);
        foreach (self::$alias as $prefix => $path) {
            if ($alias === $prefix) {
                $class = substr($class, strlen($prefix)+1);
                $file  = $path.'/'.strtr($class, '\\', '/').'.class.php';
                if (file_exists($file)) {
                    include $file;
                } else {
                    throw new AutoloaderException("File '$file' does'nt exists");
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
        self::$alias = $alias;
    }


    /**
     * Add alias
     *
     * @param array $alias
     */
    public static function addAlias($alias)
    {
        self::$alias = array_merge(self::$alias, $alias);
    }
}

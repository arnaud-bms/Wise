<?php
namespace Telco\Autoloader;

use Telco\Autoloader\AutoloaderException;

/**
 * Include class file
 *
 * @author gdievart <dievartg@gmail.com>
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
        foreach(self::$_alias as $prefix => $path) {
            if(substr($class, 0, strlen($prefix)) === $prefix) {
                $class = substr($class, strlen($prefix)+1);
                require_once $path.'/'.strtr($class, '\\', '/').'.class.php';
                return;
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

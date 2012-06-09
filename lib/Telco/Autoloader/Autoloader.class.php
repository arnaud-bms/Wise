<?php
namespace Telco\Autoloader;

use Telco\Autoloader\AutoloaderException;

/**
 * Include class file
 *
 * @author gdievart
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
                require_once $path.'/'.strtr($class, '\\', '/').'.class.php';
                return;
            }
        }
        
        throw new AutoloaderException("Class '$class' not found", 400);
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
     * @param string $prefix
     * @param string $path
     */
    public static function addAlias($prefix, $path)
    {
        self::$_alias[$prefix] = $path;
    }
}

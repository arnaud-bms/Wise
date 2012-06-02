<?php
namespace Tlc\Autoloader;

/**
 * Description of Autoloader
 *
 * @author gdievart
 */
class Autoloader 
{
    
    /**
     * Register autoload
     * 
     * @return type 
     */
    public static function registerAutoload()
    {
        return spl_autoload_register(array(__CLASS__, 'loadClass'));
    }
   
    
    /**
     * Register autoload
     * 
     * @return type 
     */
    public static function loadClass($class)
    {
        echo $class . "\n";
        if(strtolower(substr($class, 0, 3)) === 'app') {
            require_once realpath(__DIR__ . '/../../../') . '/' . strtr($class, '_\\', '//') . '.class.php';
        } else {
            require_once realpath(__DIR__ . '/../../') . '/' . strtr($class, '_\\', '//') . '.class.php';
        }
    }
}

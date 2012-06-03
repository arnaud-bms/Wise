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
    public static function loadClass($class)
    {
        echo $class . "\n";
        if(strtolower(substr($class, 0, 3)) === 'App') {
            require_once ROOT_DIR . 'app/' . strtr($class, '_\\', '//') . '.class.php';
        } else {
            require_once ROOT_DIR . 'lib/' . strtr($class, '_\\', '//') . '.class.php';
        }
    }
}

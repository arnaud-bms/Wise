<?php
namespace Telco\Component;

use Telco\Conf\Conf;

/**
 * Class base 
 *
 * @author gdievart
 */
abstract class ComponentStatic extends AbstractComponent
{
    
    /**
     * Construct Component
     * 
     * @param type $config 
     */
    public static function init($config = null)
    {
        $class = get_called_class();
        $config = self::_getComponentConfig($class, $config);
        
        if($config !== null && is_array($config) && isset($class::$_requiredFields)) {
            self::_checkRequiredFields($class::$_requiredFields, $config);
        }
        
        $class::_init($config);
    }
    
    
    /**
     * Init component
     * 
     * @param type $config 
     */
    protected static function _init($config) { }
}

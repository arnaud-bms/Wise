<?php
namespace Tlc\Component;

/**
 * Class base 
 *
 * @author gdievart
 */
abstract class ComponentStatic 
{
    
    /**
     * Construct Component
     * 
     * @param type $config 
     */
    public static function init($config = null) 
    {
        if($config !== null && is_array($config) && isset(self::$_requiredFields)) {
            self::_checkRequiredFields($config);
        }
        
        self::_init($config);
    }
    
    
    /**
     * Check is required fields is present
     * 
     * @param array $config
     */
    private static function _checkRequiredFields($config) 
    {
        foreach(self::_requiredFields as $field) {
            if(!array_key_exists($field, $config)) {
                throw new ComponentException("The field '$field' is required", 400);
            }
        }
    }
    
    
    /**
     * Init component
     * 
     * @param type $config 
     */
    protected static function _init($config) { }
}

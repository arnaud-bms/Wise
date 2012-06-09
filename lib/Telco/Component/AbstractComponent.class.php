<?php
namespace Telco\Component;

use Telco\Conf\Conf;

/**
 * Class base 
 *
 * @author gdievart
 */
abstract class AbstractComponent
{
    
    /**
     * Extract Component configuration 
     * 
     * @param string $class Class called
     * @param array $config
     * @return array
     */
    protected static function _getComponentConfig($class, $config) {
        if($config === null) {
            $configName = substr($class, strlen('Telco\\'));
            $configName = substr($configName, 0, strpos($configName, '\\'));
            $configName = strtolower($configName);

            if($componentConfig = Conf::getConfig($configName)) {
                $config = $componentConfig;
            }
        }
        
        return $config;
    }
    
 
    /**
     * Check is required fields is present
     * 
     * @param array $config
     */
    protected static function _checkRequiredFields($requiredFields, $config) 
    {
        foreach($requiredFields as $field) {
            if(!array_key_exists($field, $config)) {
                throw new ComponentException("The field '$field' is required", 400);
            }
        }
    }
}
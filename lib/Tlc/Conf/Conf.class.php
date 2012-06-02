<?php
namespace Tlc\Conf;

use \Tlc\Component\Component;

/**
 * Description of Conf
 *
 * @author gdievart
 */
class Conf extends Component 
{
    
    /**
     * @var array List config setted 
     */
    protected static $_config = array();
    
    
    /**
     * Set config
     * 
     * @param array $config
     * @param string $configName 
     */
    public static function setConfig($config, $configName = null)
    {
        self::$_config[$configName] = $config;
    }
    
    
    /**
     * Retrieve config
     * 
     * @param string $section
     * @param string $configName 
     */
    public static function getConfig($section, $configName = null)
    {
        return self::$_config[$configName][$section];
    }
}

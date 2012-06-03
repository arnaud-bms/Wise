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
     * @param string $iniFile
     */
    public static function loadConfig($iniFile)
    {
        self::$_config = parse_ini_file($iniFile, true);
    }
    
    
    /**
     * Overwrite main config 
     * 
     * @param string $iniFile
     */
    public static function mergeConfig($iniFile)
    {
        self::$_config = array_merge(
                self::$_config, 
                parse_ini_file($iniFile, true));
    }
    
    
    /**
     * Retrieve config
     * 
     * @param string $section
     */
    public static function getConfig($section = null)
    {
        if($section !== null) {
            return self::$_config[$section];
        }
        return self::$_config;
    }
}

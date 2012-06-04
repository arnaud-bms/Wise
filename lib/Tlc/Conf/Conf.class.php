<?php
namespace Tlc\Conf;

use Tlc\Component\Component;
use Tlc\Conf\ConfException;

/**
 * Configuration Class from ini files
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
     * @param string $fileConf
     */
    public static function loadConfig($fileConf)
    {
        self::$_config = self::_getConfFromFile($fileConf);
    }
    
    
    /**
     * Overwrite main config 
     * 
     * @param string $fileConf
     */
    public static function mergeConfig($fileConf)
    {
        self::$_config = array_merge(
                self::$_config, 
                self::_getConfFromFile($fileConf));
    }
    
    
    /**
     * Retrieve conf from file
     * 
     * @param string $fileConf
     * @return array
     */
    private static function _getConfFromFile($fileConf)
    {
        if(!$config = @parse_ini_file($fileConf, true)) {
            throw new ConfException("File '$fileConf' it's not valid", 400);
        }
        return $config;
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

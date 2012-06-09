<?php
namespace Telco\Conf;

use Telco\Component\ComponentStatic;
use Telco\Conf\ConfException;

/**
 * Configuration Class from ini files
 *
 * @author gdievart
 */
class Conf extends ComponentStatic
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
     * @return mixed
     */
    public static function getConfig($section = null)
    {
        $config = self::$_config;
        if($section !== null) {
            $section = explode('.', $section);
            foreach($section as $field) {
                $config = isset($config[$field]) ? $config[$field] : false;
            }
        }
        return $config;
    }
    
    
    /**
     * Retrieve config
     * 
     * @param string $section
     * @param mixed  $newConfig
     */
    public static function setConfig($section, $newConfig)
    {
        $config =& self::$_config;
        $section = explode('.', $section);
        foreach($section as $field) {
            if(isset($config[$field])) {
                $config =& $config[$field];
            } else {
                $config[$field] = null;
            }
        }
        $config = $newConfig;
    }
}

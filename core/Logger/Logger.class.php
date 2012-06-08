<?php
namespace Tlc\Logger;

use Tlc\Component\ComponentStatic;

/**
 * Format data from array to csv, json, xml, serialize ...
 *
 * @author gdievart
 */
class Logger extends ComponentStatic 
{
    /**
     * @staticvar int Log level 
     */
    const LOG_DEBUG = 0;
    const LOG_INFO = 1;
    const LOG_ERROR = 2;
    const LOG_CRIT = 3;
    
    /**
     * @var array list level 
     */
    protected static $_listLevel = array(
        0 => 'DEBUG',
        1 => 'INFO',
        2 => 'ERROR',
        3 => 'CRIT'
    );
    
    /**
     * @var array Required fields 
     */
    protected static $_requiredFields = array(
        'engine',
        'enable'
    );
    
    /**
     * @var engine Engine to load
     */
    protected static $_engineToLoad;
    
    /**
     * @var engine Engine loaded
     */
    protected static $_engineLoaded;
    
    /**
     * @var engine Engine load
     */
    protected static $_engineConfig;
    
    /**
     * @var engine Ref to engine
     */
    protected static $_engine;
    
    /**
     * @var boolean Enable log
     */
    protected static $_enable = false;
    
    /**
     * @var boolean Write message to stdout
     */
    protected static $_output = false;
    
    /**
     * Init logger
     * 
     * @param array $config
     */
    protected static function _init($config)
    {
        self::$_engineLoaded = false;
        self::$_engineToLoad = $config['engine'];
        self::$_engineConfig = $config[$config['engine']];
        
        self::$_enable = (boolean)$config['enable'];
        
        if(isset($config['output'])) {
            self::$_output = (boolean)$config['output'];
        }
    }
    
    
    /**
     * Write message
     * 
     * @param string $message
     * @param int $level 
     */
    public static function log($message, $level = self::LOG_INFO)
    {
        if(self::$_enable) {
            self::_loadEngine();
            
            $message = date('Y-m-d H:i:s') . 
                       ' [' . self::$_listLevel[$level] . '] ' . 
                       $message . PHP_EOL;
            self::$_engine->log($message, $level);
            
            if(self::$_output) {
                echo $message;
            }
        }
    }
    
    
    /**
     * Load engine Logger
     */
    protected static function _loadEngine()
    {
        if(self::$_engine === null || self::$_engineToLoad === false) {
            $class = 'Tlc\Logger\Engine\\' . ucfirst(self::$_engineToLoad);
            self::$_engine = new $class(self::$_engineConfig);
            self::$_engineLoaded = true;
        }
    }
}

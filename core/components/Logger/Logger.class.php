<?php
namespace Telco\Logger;

use Telco\Component\ComponentStatic;

/**
 * Format data from array to csv, json, xml, serialize ...
 *
 * @author gdievart <dievartg@gmail.com>
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
        'driver',
        'enable'
    );

    /**
     * @var driver Driver to load
     */
    protected static $_driverToLoad;

    /**
     * @var driver Driver loaded
     */
    protected static $_driverLoaded;

    /**
     * @var driver Driver load
     */
    protected static $_driverConfig;

    /**
     * @var driver Ref to driver
     */
    protected static $_driver;

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
        self::$_enable = (boolean)$config['enable'];

        if (isset($config['output'])) {
            self::$_output = (boolean)$config['output'];
        }

        self::$_driverLoaded = false;
        self::$_driverToLoad = $config['driver'];
        self::$_driverConfig = isset($config[$config['driver']])
                ? $config[$config['driver']]
                : null;
    }


    /**
     * Write message
     *
     * @param string $message
     * @param int $level
     */
    public static function log($message, $level = self::LOG_INFO)
    {
        if (self::$_enable) {
            self::_loadDriver();

            $message = date('Y-m-d H:i:s')
                     . ' ['.self::$_listLevel[$level].'] '.$message.PHP_EOL;
            self::$_driver->log($message, $level);

            if (self::$_output) {
                echo $message;
            }
        }
    }


    /**
     * Load driver Logger
     */
    protected static function _loadDriver()
    {
        if (self::$_driver === null || self::$_driverToLoad === false) {
            $class = 'Telco\Logger\Driver\\'.ucfirst(self::$_driverToLoad);
            self::$_driver = new $class(self::$_driverConfig);
            self::$_driverLoaded = true;
        }
    }
}

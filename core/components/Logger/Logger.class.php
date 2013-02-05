<?php
namespace Telelab\Logger;

use Telelab\Component\ComponentStatic;

/**
 * Format data from array to csv, json, xml, serialize ...
 *
 * @author gdievart <g.dievart@telemaque.fr>
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
        'enable',
    );

    /**
     * @var array Logger configuration
     */
    protected static $_loggerConf = array(
        'logger' => array(
            'to_load'    => null,
            'loaded'    => null,
            'config'    => null,
            'driver'    => null,
            'enable'    => false,
            'output'    => false,
            'prefix'    => null,
            'prefix'    => null,
            'log_level' => self::LOG_INFO,
        )
    );

    /**
     * Init logger
     *
     * @param array $config
     */
    protected static function _init($config)
    {
        $loggerName = isset($config['name']) ? $config['name'] : 'logger';
        self::$_loggerConf[$loggerName]['enable'] = (boolean)$config['enable'];

        if (isset($config['output'])) {
            self::$_loggerConf[$loggerName]['output'] = (boolean)$config['output'];
        }

        if (isset($config['log_level'])) {
            self::$_loggerConf[$loggerName]['logLevel'] = array_search($config['log_level'], self::$_listLevel);
        }

        if (isset($config['callback'])) {
            foreach ($config['callback'] as $level => $callback) {
                if ($key = array_search($level, self::$_listLevel)) {
                    self::$_loggerConf[$loggerName]['callback'][$key] = $callback;
                }
            }
        }


        self::$_loggerConf[$loggerName]['driverLoaded'] = false;
        self::$_loggerConf[$loggerName]['driverToLoad'] = $config['driver'];
        self::$_loggerConf[$loggerName]['driverConfig'] = isset($config[$config['driver']])
                ? $config[$config['driver']]
                : null;
    }


    /**
     * Write message
     *
     * @param string $message
     * @param int $level
     */
    public static function log($message, $level = self::LOG_INFO, $loggerName = 'logger')
    {
        if (self::$_loggerConf[$loggerName]['enable'] && $level >= self::$_loggerConf[$loggerName]['logLevel']) {
            self::_loadDriver($loggerName);

            $message = date('Y-m-d H:i:s')
                     . ' ['.self::$_listLevel[$level].'] '.$message.PHP_EOL;
            self::$_loggerConf[$loggerName]['driver']->log($message, $level);

            if (self::$_loggerConf[$loggerName]['output']) {
                echo $message;
            }

            if (!empty(self::$_loggerConf[$loggerName]['callback'][$level])) {
                call_user_func(self::$_loggerConf[$loggerName]['callback'][$level], (array)$message);
            }
        }
    }


    /**
     * Load driver Logger
     */
    protected static function _loadDriver($loggerName)
    {
        if (empty(self::$_loggerConf[$loggerName]['driver']) || self::$_loggerConf[$loggerName]['driverToLoad'] === false) {
            $class = 'Telelab\Logger\Driver\\'.ucfirst(self::$_loggerConf[$loggerName]['driverToLoad']);
            self::$_loggerConf[$loggerName]['driver'] = new $class(self::$_loggerConf[$loggerName]['driverConfig']);
            self::$_loggerConf[$loggerName]['driverLoaded'] = true;
        }
    }
}

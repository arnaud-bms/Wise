<?php
namespace Telco\ErrorHandler;

use Telco\Component\Component;
use Telco\Conf\Conf;
use Telco\Logger\Logger;

/**
 * Catch all error and log
 *
 * @author gdievart
 */
class ErrorHandler extends Component
{
    /**
     * Catch all error generated by php interpreter
     * 
     * @param int $errno
     * @param string $message
     */
    public static function catchError($errno, $message, $file, $line)
    {
        if($loggerConfig = Conf::getConfig('logger')) {
            $message = 'Error ['.$errno.'] '.$message.' ' .
                       'on file '.$file.' ('.$line.')';
            Logger::init($loggerConfig);
            Logger::log($message);
        }
    }
}

<?php
namespace Tlc\ExceptionHandler;

use Tlc\Component\Component;
use Tlc\Conf\Conf;
use Tlc\Logger\Logger;
use Exception;

/**
 * Catch all exception and log
 *
 * @author gdievart
 */
class ExceptionHandler extends Component
{
    /**
     * Catch all Exception no catch
     * 
     * @param Exception $e
     */
    public static function catchException(Exception $e)
    {
        if($loggerConfig = Conf::getConfig('logger')) {
            Logger::init($loggerConfig);
            Logger::log((string)$e);
        }
    }
}

<?php
namespace Telco\ExceptionHandler;

use Telco\Component\Component;
use Telco\Conf\Conf;
use Telco\Logger\Logger;
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

<?php
namespace Telco\ExceptionHandler;

use Telco\Component\Component;
use Telco\Conf\Conf;
use Telco\Logger\Logger;
use Exception;

/**
 * Catch all exception and log
 *
 * @author gdievart <dievartg@gmail.com>
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
        if((boolean)Conf::getConfig('logger.enable')) {
            Logger::init();
            Logger::log((string)$e);
        }
    }
}

<?php
namespace Wise\ExceptionHandler;

use Wise\Component\Component;
use Wise\Conf\Conf;
use Wise\Logger\Logger;
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
    public static function uncaught(Exception $e)
    {
        if ((boolean) Conf::getConfig('logger.enable')) {
            Logger::initStatic();
            Logger::log((string) $e);
        }
    }
}

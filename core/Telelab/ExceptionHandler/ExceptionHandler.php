<?php
namespace Telelab\ExceptionHandler;

use Telelab\Component\Component;
use Telelab\Conf\Conf;
use Telelab\Logger\Logger;
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
        if ((boolean) Conf::getConfig('logger.enable')) {
            Logger::initStatic();
            Logger::log((string) $e);
        }
    }
}

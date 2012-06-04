<?php
namespace Tlc\ExceptionHandler;

use Tlc\Component\Component;

/**
 * Description of ExceptionHandler
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
    public static function catchException(\Exception $e)
    {
        echo "Exception: " . $e->getMessage() . " (" . $e->getCode() . ")\n";
    }
}

<?php
namespace Telco\Logger\Driver;

/**
 * EngineInterface
 *
 * @author gdievart
 */
abstract class AbstractDriver 
{   
    abstract public function log($message, $level);
}

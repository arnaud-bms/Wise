<?php
namespace Telco\Logger\Driver;

/**
 * EngineInterface
 *
 * @author gdievart <dievartg@gmail.com>
 */
abstract class AbstractDriver 
{   
    abstract public function log($message, $level);
}

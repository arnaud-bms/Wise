<?php
namespace Tlc\Logger\Engine;

/**
 * EngineInterface
 *
 * @author gdievart
 */
interface EngineInterface 
{   
    public function log($message, $level);
}

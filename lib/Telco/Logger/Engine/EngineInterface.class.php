<?php
namespace Telco\Logger\Engine;

/**
 * EngineInterface
 *
 * @author gdievart
 */
interface EngineInterface 
{   
    public function log($message, $level);
}

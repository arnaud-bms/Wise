<?php
namespace Tlc\Cache\Engine;

/**
 * Interface of the engine cache
 *
 * @author gdievart
 */
interface EngineInterface 
{   
    public function __construct($config);
    
    public function getCache($uniqId);
    
    public function setCache($uniqId, $content);
}

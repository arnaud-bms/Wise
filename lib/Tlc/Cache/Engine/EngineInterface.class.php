<?php
namespace Tlc\Cache\Engine;

/**
 * Description of File
 *
 * @author gdievart
 */
interface EngineInterface 
{   
    public function __construct($config);
    
    public function getCache($uniqId);
    
    public function setCache($uniqId, $content);
}

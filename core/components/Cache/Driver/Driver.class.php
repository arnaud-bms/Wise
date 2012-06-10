<?php
namespace Telco\Cache\Driver;

/**
 * DriverInterface
 *
 * @author gdievart
 */
abstract class Driver 
{   
    abstract public function getCache($uniqId);
    
    abstract public function setCache($uniqId, $content);
}

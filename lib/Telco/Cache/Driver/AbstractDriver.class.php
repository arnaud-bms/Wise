<?php
namespace Telco\Cache\Driver;

/**
 * DriverInterface
 *
 * @author gdievart
 */
abstract class AbstractDriver 
{   
    abstract public function getCache($uniqId);
    
    abstract public function setCache($uniqId, $content);
}

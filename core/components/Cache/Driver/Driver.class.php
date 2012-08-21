<?php
namespace Telco\Cache\Driver;

/**
 * DriverInterface
 *
 * @author gdievart <dievartg@gmail.com>
 */
abstract class Driver 
{   
    abstract public function getCache($uniqId);
    
    abstract public function setCache($uniqId, $content);
}

<?php
namespace Telco\Cache\Driver;

use Telco\Component\Component;

/**
 * Driver
 *
 * @author gdievart <dievartg@gmail.com>
 */
abstract class Driver extends Component
{   
    abstract public function getCache($uniqId);
    
    abstract public function setCache($uniqId, $content);
}
